import './lazyload'
import Flickity from 'flickity'
import initNav from './navigation'
import initHeader from './scroll'
import initHero from './hero'
import initCarousel from './carousel'
import initObserver from './observer'
import initMenu from './menu'

function main() {
  // header
  initHeader()
  // nav
  initNav()
  // hero
  initHero()
  // carousel
  initCarousel()

  initObserver()

  initMenu()

  const lazyLoadInstance = new LazyLoad({})
}
document.addEventListener('DOMContentLoaded', () => {
  main()
})
