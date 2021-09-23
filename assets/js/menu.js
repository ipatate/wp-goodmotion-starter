import Siema from 'siema'

function initMenu() {
  const menus = document.querySelectorAll('.gm-menus')
  if (!menus) return

  menus.forEach((menu) => {
    const container = menu.querySelector('.gm-menus-list')
    // previous btn
    const previous = menu.querySelector('.gm-menu-arrow-previous')
    // next btn
    const next = menu.querySelector('.gm-menu-arrow-next')
    const dot = menu.querySelectorAll('.gm-menu-dot')

    const cell = container.querySelectorAll('.gm-menus-list-element')

    const carousel = new Siema({
      selector: container,
      onInit: () => {
        if (container.dataset.isInit !== true && cell.length > 0) {
          // set init to true
          container.dataset.isInit = true
          // get first div items, not .gm-menus-list-element
          const items = container.querySelector('div:first-child').childNodes

          if (previous) {
            previous.setAttribute('tabindex', '-1')
            previous.setAttribute('disabled', true)
            previous.classList.add('gm-arrow-disabled')
          }
          if (next) {
            next.setAttribute('tabindex', '-1')
            next.setAttribute('disabled', true)
            next.classList.add('gm-arrow-disabled')
          }
          // if more than one item active next btn
          if (items.length > 0 && next) {
            next.classList.remove('gm-arrow-disabled')
            next.removeAttribute('disabled')
            next.setAttribute('tabindex', '0')
          }
          //  aria hidden false for first element
          cell[0].setAttribute('aria-hidden', false)

          // if dot display
          if (dot.length > 0) {
            dot[0].classList.add('gm-menu-dot-current')
            dot[0].setAttribute('tabindex', 0)
            dot[0].setAttribute('aria-selected', true)
            const count = dot.length
            // listener on dot
            for (let i = 0; i < count; ++i) {
              dot[i].addEventListener('click', () => {
                carousel.goTo(i)
              })
              const f = () => {
                // has no listener
                if (dot[i].dataset.hasKeyListener === undefined) {
                  dot[i].addEventListener('keydown', (e) => {
                    // left ou up arrow pressed
                    if (
                      (e.keyCode === 37 || e.keyCode === 38) &&
                      i !== 0 &&
                      dot[i - 1] !== undefined
                    ) {
                      dot[i].setAttribute('tabindex', -1)
                      dot[i - 1].setAttribute('tabindex', 0)
                      dot[i - 1].focus()
                    } else if (
                      // right or down arrow pressed
                      (e.keyCode === 39 || e.keyCode === 40) &&
                      i !== count &&
                      dot[i + 1] !== undefined
                    ) {
                      dot[i].setAttribute('tabindex', -1)
                      dot[i + 1].setAttribute('tabindex', 0)
                      dot[i + 1].focus()
                    }
                    if (
                      e.keyCode === 37 ||
                      e.keyCode === 38 ||
                      e.keyCode === 39 ||
                      e.keyCode === 40
                    ) {
                      e.preventDefault()
                    }
                  })
                  // add data for not added new listener
                  dot[i].dataset.hasKeyListener = true
                }
              }
              dot[i].addEventListener('focus', f)
            }
          }
        }
      },
      onChange: () => {
        const countCell = cell.length
        // all cell with aria-hidden true
        for (let i = 0; i < countCell; ++i) {
          cell[i].style.float = null
          cell[i].setAttribute('aria-hidden', true)
        }
        // aria-hidden false for current
        cell[carousel.currentSlide].setAttribute('aria-hidden', false)

        /** btn arrow */
        if (previous) {
          previous.setAttribute(
            'tabindex',
            carousel.currentSlide > 0 ? '0' : -1,
          )
          if (carousel.currentSlide > 0) {
            previous.removeAttribute('disabled')
            previous.classList.remove('gm-arrow-disabled')
          } else {
            previous.setAttribute('disabled', true)
            previous.classList.add('gm-arrow-disabled')
          }
        }
        if (next) {
          if (carousel.currentSlide === countCell - 1) {
            next.setAttribute('disabled', true)
            next.classList.add('gm-arrow-disabled')
          } else {
            next.removeAttribute('disabled')
            next.classList.remove('gm-arrow-disabled')
          }

          if (countCell > 0) {
            next.setAttribute(
              'tabindex',
              carousel.currentSlide !== countCell - 1 ? '0' : -1,
            )
          }
        }
        /** dot */
        const count = dot.length
        for (let i = 0; i < count; ++i) {
          dot[i].setAttribute('tabindex', -1)
          dot[i].setAttribute('aria-selected', false)
          dot[i].classList.remove('gm-menu-dot-current')
        }
        const current = dot[carousel.currentSlide]
        current.classList.add('gm-menu-dot-current')
        current.setAttribute('tabindex', 0)
        current.setAttribute('aria-selected', true)
      },
    })
    if (next && previous) {
      previous.addEventListener('click', () => {
        carousel.prev()
      })
      next.addEventListener('click', () => {
        carousel.next()
      })
    }
  })
}

export default initMenu
