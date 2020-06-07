import urllib.request
import re
import pymysql
import os
import random
import json
from urllib.request import urlopen, Request

db = pymysql.connect("localhost", "root", "87654321", "AnShop")
cursor = db.cursor()

patterns = {
    '[àáảãạăắằẵặẳâầấậẫẩ]': 'a',
    '[đ]': 'd',
    '[èéẻẽẹêềếểễệ]': 'e',
    '[ìíỉĩị]': 'i',
    '[òóỏõọôồốổỗộơờớởỡợ]': 'o',
    '[ùúủũụưừứửữự]': 'u',
    '[ỳýỷỹỵ]': 'y',
    ' ': '-'
}

def convert(text):
    output = text
    for regex, replace in patterns.items():
        output = re.sub(regex, replace, output)
        # deal with upper case
        output = re.sub(regex.upper(), replace.upper(), output)
    return output.lower()

def downloadIMG(url, path):
    opener=urllib.request.build_opener()
    opener.addheaders=[('User-Agent','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1941.0 Safari/537.36')]
    urllib.request.install_opener(opener)
    urllib.request.urlretrieve(url, path)
    print("\tSave to ", path)

def getHTMLFromUrl(url):
    fp = urllib.request.urlopen(url)
    mybytes = fp.read()
    html = mybytes.decode("utf8")
    fp.close()
    return html


def getLinkProduct(html):
    result = []
    regexLink = r'<a target=\"_blank\" href=\"(.*)\" class=\"img-link-pr\" title=\"(.*)\">'
    regexImage = r'<img class=\"img-responsive lazyload\" data-src=\"(.*)\" src='
    dataLink = re.findall(regexLink, html)
    dataImage  = re.findall(regexImage, html)

    for i in range(dataLink.count):
        tmp =  dataLink[i].split("/");
        groupName = tmp[tmp.length-1].split("?")[0];
        if(groupName.length > 9):
            continue
        if(dataImage[i] is None):
            continue
        result.push( ["https://coupletx.com" + dataLink[i], dataImage[i]])
    return result

def getProduct(url, idCategory, idType):
    html = getHTMLFromUrl(url)

    rawData = json.loads(str(re.findall(r'window.productJSON = (.*);', html)[0]))
    code= rawData["handle"]
    name = rawData["title"]
    description = rawData["description"]
    price = int(rawData["price"])
    featuredImage = rawData["featured_image"]
    images = rawData["images"]
    type = rawData["type"]
    idGroup = -1

    path = "images/products/"+type+"/"+code+"/"
    if not os.path.exists(path):
        os.makedirs(path)
        featuredImageName = featuredImage.split("_")[len(featuredImage.split("_"))-1]
        downloadIMG(featuredImage, path+featuredImageName)
    else:
        print("Product ", name, "already existed")
        return

    query = "INSERT INTO `AnShop`.`group_products` (`group_name`, `group_code`, `price`, `desciption`, `image`, `id_category`, `type`) VALUES (%s, %s, %d, %s, %s, %d, %d)"
    value = [name, code, price, description, path+featuredImageName, idCategory, idType]
    try:
        cursor.execute(query, value)
        db.commit()
        print("Inserted "+name)
        idGroup = int(cursor.lastrowid)
    except:
        print("Error in insert", name)
        return

    if idGroup == -1:
        print("Error when get id group")
        return

    imagePerColor = {}

    for image in images:
        correction = re.findall(r'product/(.*)_(.*)__\d__(.*)', image)
        if len(correction) > 0:
            correction = correction[0]
            if correction[1] not in imagePerColor:
                imagePerColor[str(correction[1])] = []
            imagePerColor[str(correction[1])].append({"image_name": correction[2], "link": image})
        else :
            retry = re.findall(r'product/(.*)_(.*)_(.*)', image)
            if len(retry) > 0:
                retry = retry[0]
                if retry[0] == 'men' or retry[0] == 'lady' or retry[0] == 'couple':
                    if retry[1] not in imagePerColor:
                        imagePerColor[str(retry[1])] = []
                    imagePerColor[str(retry[1])].append({"image_name":retry[2], "link":image})

    colors = []
    idColor = -1
    for item in rawData["variants"]:
        color = item["option1"]
        if color not in colors:
            colors.append(color)
            cursor.execute("INSERT INTO `AnShop`.`product_color` (`color`, `id_group_product`) VALUES ( %s, %d)", [color, idGroup])
            db.commit()
            idColor = int(cursor.lastrowid)
            for image in imagePerColor[convert(color)]:
                try:
                    queryImage = "INSERT INTO `AnShop`.`product_images` (`path`, `id_product_color`) values (%s, %d)" % (path+image['image_name'], idColor)
                    cursor.execute(queryImage)
                    db.commit()
                    print("\tInserted ",image)
                    downloadIMG(image['link'], path+image['image_name'])
                except:
                    print("Error in insert", image['image_name'])
        if idColor != -1:
            query = "INSERT INTO `AnShop`.`products` (`size`, `quantity_stogare`, `id_product_color`) values (%s, %d, %d)" % (item["option3"], item["inventory_quantity"], idColor)
            cursor.execute(queryImage)
            db.commit()
        else:
            print("Error when insert size:", color, item["option3"])


html = getHTMLFromUrl("https://coupletx.com/collections/m-ao-so-mi-nam")
matchs = re.findall(r'<a target=\"_blank\" href=\"(.*)\" class=\"img-link-pr\" title=\"(.*)\">', html)
for match in matchs:
    url = 'https://coupletx.com' + match[0]
    getProduct(url, 1, 1)

