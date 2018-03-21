export const setCookie = (name, value, timeNum) => {
  let exp = new Date()
  exp.setTime(exp.getTime() + timeNum * 60 * 1000)
  document.cookie = name + '=' + escape(value) + ';expires=' + exp.toGMTString()
}

export const getCookie = (name) => {
  var arr, reg = new RegExp('(^| )' + name + '=([^;]*)(;|$)')
  if (arr = document.cookie.match(reg))
  return unescape(arr[2])
  else
  return null
}

export const delCookie = (name) => {
	var exp = new Date()
	exp.setTime(exp.getTime() - 1)
	var cval = getCookie(name)
	if(cval != null)
	document.cookie = name + '=' + cval + ';expires=' + exp.toGMTString()
}
