// chart-generator.js
const puppeteer = require('puppeteer');

async function generateChart(htmlContent) {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    
    // Set content
    await page.setContent(Buffer.from(htmlContent, 'base64').toString());
    
    // Wait for chart to render
    await page.waitForSelector('#earningsChart');
    
    // Take screenshot
    const element = await page.$('#earningsChart');
    const image = await element.screenshot({
        encoding: 'base64'
    });
    
    await browser.close();
    
    return image;
}

// Get chart HTML from command line argument
const chartHtml = process.argv[2];
generateChart(chartHtml).then(console.log);