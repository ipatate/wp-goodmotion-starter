let posY = 0
const body = document.body
const initHeader = () => {
  window.addEventListener('scroll', scrollDirectionChange, { passive: true })
  scrollDirectionChange()
}

const scrollDirectionChange = () => {
  // update only for mobile
  window.requestAnimationFrame(() => {
    const _posY = window.scrollY || window.pageYOffset
    let newMove = _posY < posY ? 'UP' : 'DOWN'
    const list = body.classList

    if (_posY < 200) {
      list.add('page-istop')
    } else {
      list.remove('page-istop')
    }
    posY = _posY
    if (newMove === 'UP' && _posY > 200) {
      list.add('page-isup')
    } else if (_posY > 200) {
      list.remove('page-isup')
    } else {
      list.add('page-isup')
    }
  })
}

export default initHeader
