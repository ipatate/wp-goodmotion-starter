import { debounce } from 'throttle-debounce'

const initNav = () => {
  const header = document.querySelector('.gm-header')
  const navBtn = document.querySelector('.gm-burger')
  const navMain = document.querySelector('.gm-nav-main')

  if (navBtn) {
    navBtn.addEventListener('click', (e) => {
      const target = e.currentTarget
      header.classList.toggle('gm-nav-open')
      target.classList.toggle('gm-nav-open')
      navMain.classList.toggle('gm-nav-main-open')
      navBtn.setAttribute(
        'aria-expanded',
        navMain.classList.contains('gm-nav-main-open'),
      )
      if (target.classList.contains('gm-nav-open')) {
        return (document.body.style.overflow = 'hidden')
      }
      document.body.style.overflow = 'visible'
    })
  }

  detectMobileNav()

  window.addEventListener(
    'resize',
    debounce(200, () => detectMobileNav()),
  )
}

const detectMobileNav = () => {
  // the nav
  const nav = document.querySelector('nav#nav-main')
  if (!nav) return
  const navPosition = window
    .getComputedStyle(nav, null)
    .getPropertyValue('position')

  // open sub nav on mobile
  const openUL = (event) => {
    event.preventDefault()
    const parent = event.currentTarget.parentNode
    const childNav = parent.querySelector('ul')
    parent.setAttribute(
      'aria-expanded',
      !parent.classList.contains('is-opened'),
    )
    childNav.setAttribute('aria-hidden', parent.classList.contains('is-opened'))
    parent.classList.toggle('is-opened')
  }

  const collapse = document.querySelectorAll(
    'nav > ul > li.menu-item-has-children',
  )

  // expande sub nav mobile
  const toggleExpanded = (event, state) => {
    const a = event.currentTarget.querySelector('a')
    const childNav = event.currentTarget.querySelector('ul')
    if (!a) {
      return
    }
    if (a.getAttribute('aria-expanded') !== String(state)) {
      childNav.setAttribute('aria-hidden', !state)
      a.setAttribute('aria-expanded', state)
    }
    if (state === false) {
      const childrens = childNav.children
      if (childrens.length > 0) {
        childrens[0].classList.add('gm-hide-desktop')
      }
    }
  }

  // if nav is fixed == is mobile nav mode
  if (navPosition === 'fixed') {
    collapse.forEach((e) => {
      const a = e.querySelector('a')
      if (a) {
        a.removeEventListener('click', openUL)
        a.addEventListener('click', openUL)
      }
    })
  } else {
    // change aria on hover
    collapse.forEach((e) => {
      e.addEventListener('mouseover', (event) => toggleExpanded(event, true))
      e.addEventListener('mouseout', (event) => toggleExpanded(event, false))
    })

    /** A11Y Navigation */

    // search link first level
    const collapseLink = document.querySelectorAll(
      'nav > ul > li.menu-item-has-children > a',
    )

    const resetChildren = (childrens) => {
      if (!childrens) return
      // reset
      for (let index = 0; index < childrens.length; index++) {
        childrens[index].setAttribute('aria-selected', false)
      }
    }

    /**
     * use key for show sub navigation
     * @param {event} e
     */
    const navA11Y = (e) => {
      const { keyCode, currentTarget, target } = e
      if (
        // down
        keyCode === 40 ||
        // up
        keyCode === 38 ||
        // space
        keyCode === 32 ||
        // enter
        keyCode === 13 ||
        // right
        keyCode === 39 ||
        // left
        keyCode === 37
      ) {
        // child navigation
        const childNav = currentTarget.querySelector('ul')
        if (!childNav) {
          return
        }
        // li list of childnav
        const childrens = childNav.children
        if (childrens.length < 1) {
          return
        }

        // find last selected
        const nodes = Array.prototype.slice.call(childrens)
        const last = childNav.querySelector("[aria-selected='true']")
        let i = last ? nodes.indexOf(last) : 0
        // reset aria-selected
        resetChildren(childrens)

        // open sub nav
        if (keyCode === 40 || keyCode === 13 || keyCode === 32) {
          // if not open
          if (currentTarget.classList.contains('is-collapsed') === false) {
            e.preventDefault()
            // show first link
            childrens[i].classList.remove('gm-hide-desktop')
            // show the sub nav
            currentTarget.classList.add('is-collapsed')
            // select the fist li
            childrens[i].setAttribute('aria-selected', true)
            toggleExpanded(e, true)
            // select the first element
            const link = childrens[i].querySelector('a')
            return setTimeout(() => link.focus(), 100)
          }
        }

        // press enter, if children a, go to
        if (keyCode === 13) {
          if (target.classList.contains('menu-item-has-children')) {
            e.preventDefault()
          }
        }

        // down on children nav list
        if (keyCode === 40 || keyCode === 39) {
          if (currentTarget.classList.contains('is-collapsed') === true) {
            e.preventDefault()
            // max is attempt => stop on the last
            i = i < childrens.length - 1 ? i + 1 : i
            childrens[i].setAttribute('aria-selected', true)
            const link = childrens[i].querySelector('a')
            return link.focus()
          }
        }

        // close children nav
        if (keyCode === 38 || keyCode === 37) {
          // if is open and on the first element
          if (
            currentTarget.classList.contains('is-collapsed') === true &&
            i === 0
          ) {
            e.preventDefault()
            currentTarget.classList.remove('is-collapsed')
            toggleExpanded(e, false)
            const link = currentTarget.querySelector('a')
            // reset i
            i = 0
            return link.focus()
          }
          // if is open and the selected is not the first, up selected element
          if (
            currentTarget.classList.contains('is-collapsed') === true &&
            i > 0
          ) {
            i--
            childrens[i].setAttribute('aria-selected', true)
            const link = childrens[i].querySelector('a')
            return link.focus()
          }
        }
      }
    }

    // close children nav
    const closeChildrenNav = (parent) => {
      if (parent.classList.contains('is-collapsed') === true) {
        parent.classList.remove('is-collapsed')
        const childNav = parent.querySelector('ul')
        if (childNav.children.length > 0) {
          // hide first element child
          const firstA = childNav.children[0]
          firstA.classList.add('gm-hide-desktop')
          resetChildren(childNav.children)
        }
        document.removeEventListener('click', () => closeChildrenNav(parent))
      }
    }

    // listen the focus of parent chidren nav
    const listenFocus = (event) => {
      const t = event.currentTarget
      // li parent tag
      const parent = t.parentNode
      // if has children
      parent.addEventListener('keydown', navA11Y)
      // only if focus has call
      document.addEventListener('click', () => closeChildrenNav(parent))
    }
    // detect focus
    collapseLink.forEach((e) => {
      e.addEventListener('focus', listenFocus)
    })
  }
}

export default initNav
