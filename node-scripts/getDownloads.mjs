import gplay from 'google-play-scraper';

const appId = process.argv[2]; // Get app ID from command-line arguments

gplay.app({ appId })
    .then(app => console.log(app.installs))
    .catch(err => console.error(err));
