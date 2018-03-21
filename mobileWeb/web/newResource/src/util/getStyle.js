const getStyle = (element, attr) => {
  return window.getComputedStyle(element, null)[attr]
}

export default getStyle
