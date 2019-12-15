const axios = require('axios')
const fs = require('fs');
const downloader = require('image-downloader');
const mysql = require('mysql');
var productID = 1;

const con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
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

async function getLinkProduct(url) {
    let productLinks = [];
    const regex = /<a target="_blank" href="(.*)" class="img-link-pr" title="(.*)">/gm;
    let data = await getDataFromHTML(url, regex);

    data.forEach(match => {
        match = 'https://coupletx.com' + match;
        productLinks.push(match);
    })

    return productLinks;
}

async function getProductFromLink(html, url) {
    var color = url.split("=")[1];
    var tmp = url.split("/");
    var groupName = tmp[tmp.length-1].split("?")[0];
    var sizes ;
    let detail;
    let nameProductVN = [];
    let prices = [];
    let images = [];
    let groupProductID = 0;

    let regexName = /<div class="product-title">\n							<h4>(.*)<\/h4>/gm;
    let regexPrice = /<div class="product-price" id="price-preview">\n<span>(.*)<\/span>/gm;
    let regexDetail = /<div class="note-detail" style="height:200px;overflow: scroll;padding:10px">\n								<span style="color:#000;font-size:12px;">\n(.*)<\/span>/gm;
    let regexSize = /<div data-value="(.*)" class="swatch-element">/gm;
    let regexIMG = /<img class="product-image-feature lady" src="(.*)" alt="(.*)">/gm;
    console.log('\n\n--------------------------------------------------------------');
    console.log('---------------------'+groupName+'--------------------------');
    await getDataFromHTML(html, regexName)
    .then(data => {
        nameProductVN = data;
    })
    .then(
        getDataFromHTML(html, regexDetail)
        .then(data => {detail = data[0].split("'").join(' ')})
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
                    dest: './products/women/' + groupName + '/' + imgName
                }
                images.push(image);
            });
        })
    )
    .then(() =>{

        inserSQL('INSERT INTO `groupproducts`(`GroupName`, `GroupNameNoVN`, `Price`, `Description`, `Sale`, `CategoryID`, `Type`) VALUES (\''+nameProductVN[0]+'\',\''+groupName+'\',\''+prices[0]+'\',\''+detail+'\',0, 5,\'Women\')')
        .then((result) =>{
            createFolder("./products/women/" + groupName);
            console.log("Inserted", groupName);
        })
        .catch(err => console.log("error when insert", groupName));
    });

    await selectSQL('SELECT `GroupProductID` FROM `groupproducts` WHERE GroupNameNoVN = \''+groupName+'\'')
        .then(result =>{
            groupProductID = result[0]['GroupProductID'];
    });

    await images.forEach(async function(image){
        await inserSQL('INSERT INTO `productimages`(`Path`, `GroupProductID`, `Color`) VALUES (\''+image.dest+'\','+groupProductID+',\''+color+'\')')
        .then((result) =>{
            console.log("Inserted", image.dest);
            downloader.image(image)
            .then(({ filename, image }) => {
                console.log('Saved to', filename);
            })
        })
    });

    await sizes.forEach(async function (size){
        await inserSQL('INSERT INTO `products`(`Color`, `Size`, `QuantityStorage`, `GroupProductID`, `QuantitySelled`, `View`) VALUES (\''+color+'\',\''+size+'\',10,'+groupProductID+',0,0)')
        .then(result => console.log("Inserted", size));
    })
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
    let html = await getHTML('https://coupletx.com/collections/w-quan-nu');
    let productLinks = await getLinkProduct(html);
    productLinks.forEach(async function(link){
        let htmlProduct = await getHTML(link);
        await getProductFromLink(htmlProduct, link);
    })

}
main();
