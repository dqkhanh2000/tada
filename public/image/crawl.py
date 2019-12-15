import urllib.request
import re
import pymysql
import os
import random
from urllib.request import urlopen, Request

db = pymysql.connect("localhost", "root", "87654321", "AnShop")
cursor = db.cursor()

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

def findRegexInHTML(regex, html):
    matchs = re.findall(regex, html)
    return matchs

def getLinkProduct(html):
    result = []
    regexLink = r'<a target=\"_blank\" href=\"(.*)\" class=\"img-link-pr\" title=\"(.*)\">'
    regexImage = r'<img class=\"img-responsive lazyload\" data-src=\"(.*)\" src='
    dataLink = findRegexInHTML(html, regexLink)
    dataImage  = findRegexInHTML(html, regexImage)

    for i in range(dataLink.count):
        tmp =  dataLink[i].split("/");
        groupName = tmp[tmp.length-1].split("?")[0];
        if(groupName.length > 9):
            continue
        if(dataImage[i] is None):
            continue
        result.push( ["https://coupletx.com" + dataLink[i], dataImage[i]])
    return result

def getProduct(url):
    html = getHTMLFromUrl(url)

    productNameVN = findRegexInHTML(r'<div class=\"product-title\">\n	\t\t\t\t\t\t<h4>(.*)<\/h4>', html)
    productDetail = findRegexInHTML(r'<div class=\"note-detail\" style=\"height:200px;overflow: scroll;padding:10px\">\n\t\t\t\t\t\t\t\t<span style=\"color:#000;font-size:12px;\">\n(.*)<\/span>', html)
    productPrice = findRegexInHTML(r'<div class=\"product-price\" id=\"price-preview\">\n<span>(.*)<\/span>', html)
    query = "INSERT INTO `AnShop`.`Products` (`ProductName`, `GroupSizeID`,`CategoryID`, `Price`, `UnitsInStock`, `Detail`, `Deleted`) VALUES (%s, 4, 3, %s, 50, %s, 0)"
    value = [productNameVN, productPrice, productDetail]
    try:
        cursor.execute(query, value)
        db.commit()
        print("Inserted "+productNameVN)
    except:
        print("Error in insert", productNameVN)

    queryGetID = "SELECT ProductID FROM AnShop.Products where ProductName = %s"
    cursor.execute(queryGetID, productNameVN)
    result = cursor.fetchone()
    productID =  int(result[0])

    tmp = url.split("/");
    productName = tmp[len(tmp)-1].split("?")[0]
    color = url.split("=")[1]
    colorID = int()

    linkImages = re.findall(r'<img class=\"product-image-feature men\" src=\"(.*)\" ', html)
    for link in linkImages:
        link = "http:" +link
        imgName = ""
        try:
            imgName = link.split("_")[5]
        except:
            imgName = "undefined%d" % (random.randrange(1000))
        path = "./products/men/"+productName

        if not os.path.exists(path):
            os.makedirs(path)

        fullPath = path+"/"+imgName+".jpg"

        try:
            queryImage = "Insert into ImageProduct (ProductID, ColorID, LinkImage) values (%d, %d, '%s')" % \
            (productID, colorID, fullPath)
            cursor.execute(queryImage)
            db.commit()
            print("\tInserted ",imgName)
            downloadIMG(link, fullPath)
        except:
            print("Error in insert", imgName)




html = getHTMLFromUrl("https://coupletx.com/collections/m-ao-so-mi-nam")
matchs = findRegexInHTML(r'<a target=\"_blank\" href=\"(.*)\" class=\"img-link-pr\" title=\"(.*)\">', html)
for match in matchs:
    url = 'https://coupletx.com' + match[0]
    print('\n', match)
    # getProduct(url)

