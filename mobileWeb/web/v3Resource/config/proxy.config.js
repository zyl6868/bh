// const port = require('./index').dev.port
// const domain = 'http://localhost:' + port + '/Mock'
// const domain1 = 'http://192.168.4.126:84'
// const domain1 = 'http://192.168.4.17:8383'
const domain1 = 'http://192.168.1.225:91'
const proxy = [
  // {
  //   url: ['/courseware'],
  //   target: domain
  // }
  {
    url: ['/courseware', '/homework', '/keywords', '/site'],
    target: domain1
  }
]

module.exports = proxy
