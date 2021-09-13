import './lazyload'
import Flickity from 'flickity'
import initNav from './navigation'
import initHeader from './scroll'
import initHero from './hero'
import initCarousel from './carousel'
import initObserver from './observer'

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

  const lazyLoadInstance = new LazyLoad({})
}
document.addEventListener('DOMContentLoaded', () => {
  main()
})
