const axios = require('axios')
const fs = require('fs');
const downloader = require('image-downloader');
const mysql = require('mysql');
var productID = 1;

const con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "87654321",
    database: "dbtada"
});

con.connect(function (err) {
    if (err) throw err;
    console.log("Connected!");
});

function createFolder(path) {
    try {
        if (!fs.existsSync(path)) {
            fs.mkdirSync(path);
        }
    } catch (err) {
        console.log(err)
    }
}

async function getHTML(url){
    let html = ""
    await axios.get(url)
        .then(datas => {
            html = datas.data;
    });
    return html;
}

async function getDataFromHTML(html, regex) {
    var matchDatas = [];
    let m;
    while ((m = regex.exec(html)) !== null) {
        // This is necessary to avoid infinite loops with zero-width matches
        if (m.index === regex.lastIndex) {
            regex.lastIndex++;
        }
        m.forEach((match, groupIndex) => {
            if (groupIndex == 1) {
                if(matchDatas.indexOf(match) === -1)
                matchDatas.push(match);
            }
        })

    }
    return new Promise((resolve, reject) =>{
        resolve(matchDatas);
    })
}

async function getLinkProduct(html) {
    let result = [];
    const regexLink = /<a target="_blank" href="(.*)" class="img-link-pr" title="(.*)">/gm;
    const regexImage = /<img class="img-responsive lazyload" data-src="(.*)" src=/gm;
    let dataLink = await getDataFromHTML(html, regexLink);
    let dataImage  = await getDataFromHTML(html, regexImage);

    for(var i = 0; i < dataLink.length; i++){
        var tmp =  dataLink[i].split("/");
        var groupName = tmp[tmp.length-1].split("?")[0];
        if(groupName.length > 9) continue;
        if(!dataImage[i]) continue;
        result.push( { link: "https://coupletx.com" + dataLink[i], imageLink: dataImage[i]});
    }
    return result;
}

async function getProductFromLink(html, url, img) {
    var color = url.split("=")[1];
    var tmp = url.split("/");
    var groupName = tmp[tmp.length-1].split("?")[0];
    var sizes ;
    let detail;
    let nameProductVN = [];
    let prices = [];
    let images = [];
    let groupProductID = 0;
    let productByColorID = 0;
    let smallImage = "products/a/" + groupName + "/img"+ parseInt(Math.random()*1000000) + ".jpg";

    let regexName = /<div class="product-title">\n							<h4>(.*)<\/h4>/gm;
    let regexPrice = /<div class="product-price" id="price-preview">\n<span>(.*)<\/span>/gm;
    let regexDetail = /<div class="note-detail" style="height:200px;overflow: scroll;padding:10px">\n								<span style="color:#000;font-size:12px;">\n(.*)<\/span>/gm;
    let regexSize = /<div data-value="(.*)" class="swatch-element">/gm;
    let regexIMG = /<img class="product-image-feature a" src="(.*)" alt="(.*)">/gm;

    await getDataFromHTML(html, regexName)
        .then(data => {
            nameProductVN = data;
        })
        .then(
            getDataFromHTML(html, regexDetail)
            .then(data => {detail = data[0].split("'").join(' ').trim()})
        )
        .then(
            getDataFromHTML(html, regexPrice)
            .then(data => prices = data)
        )
        .then(
            getDataFromHTML(html, regexSize)
            .then(data => sizes = data)
        )
        .then(
            getDataFromHTML(html, regexIMG)
            .then(datas =>{
                datas.forEach(data =>{
                    data = 'https:' + data;
                    var tmp = data.split('/');
                    var imgName = tmp[tmp.length - 1];
                    imgName = imgName.replace('?', '_');
                    const image = {
                        url: data,
                        dest: 'products/a/' + groupName + '/' + imgName
                    }
                    images.push(image);
                });
            })
        )
        .then(() =>{
            inserSQL('INSERT INTO `groupproducts`(`GroupName`, `GroupNaaoVN`, `Price`, `Description`, `Sale`, `CategoryID`, `Type`) VALUES (\''+nameProductVN[0]+'\',\''+groupName+'\',\''+prices[0]+'\',\''+detail+'\',0, 16,\'a\')')
            .then((result) =>{
                createFolder("./products/a/" + groupName);
                console.log("Inserted", groupName);
            })
            .catch(err => {
                console.log("error when insert", groupName, '\n');
                // if(err.message.indexOf("Data too long") != -1) console.log('INSERT INTO `groupproducts`(`GroupName`, `GroupNameNoVN`, `Price`, `Description`, `Sale`, `CategoryID`, `Type`) VALUES (\''+nameProductVN[0]+'\',\''+groupName+'\',\''+prices[0]+'\',\''+detail+'\',0, 1,\'Women\')');
            });
        });

    await selectSQL('SELECT `GroupProductID` FROM `groupproducts` WHERE GroupNameNoVN = \''+groupName+'\'')
        .then(result =>{
            if(result[0]) groupProductID = result[0]['GroupProductID'];
    });

    await inserSQL("INSERT INTO `productbycolors`(`SmallImage`, `Color`, `GroupProductID`) VALUES ('"+smallImage+"', '"+ color+"', "+groupProductID+")")
    .then(() =>{
        downloader.image({
            url: "http:"+img,
            dest: "./"+smallImage
        }).then(console.log("saved small image"))
        .catch(err => console.log("error when save small image", err));
    }).catch(err => console.log("error when insert small image", err));

    await selectSQL('SELECT `ProductByColorID` FROM `productbycolors` WHERE Color = \''+color+'\' and ' + "GroupProductID = "+groupProductID)
        .then(result =>{
            productByColorID = result[0]['ProductByColorID'];
    });

    await images.forEach(function(image){
        inserSQL('INSERT INTO `productimages`(`Path`, `ProductByColorID`) VALUES (\''+image.dest+'\','+productByColorID+')')
        .then((result) =>{
            console.log("Inserted", image.dest);
            downloader.image({url: image.url, dest: "./" + image.dest})
            .then(({ filename, image }) => {
                console.log('Saved to', filename);
            })
        })
    });

    await sizes.forEach(function (size){
        inserSQL('INSERT INTO `products`(`Size`, `QuantityStorage`, `ProductByColorID`, `QuantitySelled`, `View`) VALUES (\''+size+'\',10,'+productByColorID+',0,0)')
        .then(result => console.log("Inserted", size));
    });

    console.log('\n\n--------------------------------------------------------------');
    console.log('------------------'+groupName+' done--------------------------');
}

function inserSQL(query) {
    return new Promise((resolve, reject) =>{
        con.query(query, function (err, result) {
            if (err) {
                reject(err);
            }else{
                resolve(result);
            }
        })
    });
}

function selectSQL(query) {
    return new Promise((resolve, reject) =>{
        con.query(query, function (err, result) {
            if (err) {
                reject(err);
            }else{
                resolve(result);
            }
        })
    });
}

async function main() {
    let html = await getHTML('https://coupletx.com/collections/a-ba-lo-1');
    let productLinks = await getLinkProduct(html);
    productLinks.forEach(async function(data){
        let htmlProduct = await getHTML(data.link);
        await getProductFromLink(htmlProduct, data.link, data.imageLink);
    })

}

main();
