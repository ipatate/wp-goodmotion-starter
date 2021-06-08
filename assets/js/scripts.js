import initNav from './navigation'
import initHeader from './scroll'

function main() {
  // header
  initHeader()
  // nav
  initNav()
}
document.addEventListener('DOMContentLoaded', () => {
  main()
})
