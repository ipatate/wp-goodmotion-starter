import Siema from 'siema'

export const initHero = () => {
  const c_car = document.querySelectorAll('.gm-hero-container')

  if (c_car) {
    const count = c_car.length
    for (let i = 0; i < count; ++i) {
      const hasDot = c_car[i].dataset.dot
      const hasArrow = c_car[i].dataset.arrow
      const autoplay = c_car[i].dataset.autoplay
      // find container
      const car = c_car[i].querySelector('.gm-hero')
      // previous btn
      const previous = c_car[i].querySelector('.gm-hero-arrow-previous')
      const playBtn = c_car[i].querySelector('.gm-hero-autoplay')
      // next btn
      const next = c_car[i].querySelector('.gm-hero-arrow-next')
      // dot
      const dot = c_car[i].querySelectorAll('.gm-hero-dot')
      // items
      const cell = c_car[i].querySelectorAll('.gm-hero-cell')

      // if not already initialized
      if (car.dataset.isInit !== true && cell.length > 0) {
        const carousel = new Siema({
          selector: car,
          onInit: () => {
            // set init to true
            car.dataset.isInit = true
            // get first div items, not .gm-hero-cell
            const items = car.querySelector('div:first-child').childNodes
            // init arrow btn
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
            // remove float and hide all items
            for (let a = 0; a < items.length; ++a) {
              items[a].style.float = null
              cell[a].setAttribute('aria-hidden', true)
            }
            //  aria hidden false for first element
            cell[0].setAttribute('aria-hidden', false)
            // if dot display
            if (hasDot === 'true' && dot.length > 0) {
              dot[0].classList.add('gm-hero-dot-current')
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
            /** dot */
            if (hasDot === 'true') {
              const count = dot.length
              for (let i = 0; i < count; ++i) {
                dot[i].setAttribute('tabindex', -1)
                dot[i].setAttribute('aria-selected', false)
                dot[i].classList.remove('gm-hero-dot-current')
              }
              const current = dot[carousel.currentSlide]
              current.classList.add('gm-hero-dot-current')
              current.setAttribute('tabindex', 0)
              current.setAttribute('aria-selected', true)
            }
          },
        })
        if (hasArrow === 'true' && next && previous) {
          previous.addEventListener('click', () => {
            carousel.prev()
          })
          next.addEventListener('click', () => {
            carousel.next()
          })
        }

        // autoplay
        if (cell.length > 0 && autoplay) {
          let order = 'up'
          let run = true
          const _autoplay = () => {
            // up or down
            if (carousel.currentSlide === cell.length - 1) {
              order = 'down'
            } else if (carousel.currentSlide === 0) {
              order = 'up'
            }
            if (order === 'up') {
              carousel.next()
            } else {
              carousel.prev()
            }
          }
          if (playBtn) {
            const playLabel = playBtn.dataset.play
            const pauseLabel = playBtn.dataset.pause
            let start
            const play = () => {
              playBtn.querySelector('span').innerHTML = pauseLabel
              playBtn.classList.toggle('play')
              start = setInterval(_autoplay, autoplay)
              run = true
            }

            const pause = () => {
              playBtn.querySelector('span').innerHTML = playLabel
              playBtn.classList.toggle('play')
              clearInterval(start)
              run = false
            }
            // click on btn
            playBtn.addEventListener('click', () => {
              if (run === true) {
                pause()
              } else {
                play()
              }
            })
            play()
          }
        }
      }
    }
  }
}

export default initHero
