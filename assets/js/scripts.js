import initNav from './navigation'
import initHeader from './scroll'
import initHero from './hero'

function main() {
  // header
  initHeader()
  // nav
  initNav()
  // hero
  initHero()
}
document.addEventListener('DOMContentLoaded', () => {
  main()
})
