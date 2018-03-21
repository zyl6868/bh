const Mock = require('mockjs')

module.exports = name => (req, res) => {
  // setTimeout(() => {
  res.json(Mock.mock(require('./' + name)))
  // }, 1000)
}
