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

  initObserver();
}
document.addEventListener('DOMContentLoaded', () => {
  main()
})
