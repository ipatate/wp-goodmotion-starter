import Flickity from 'flickity'
import initNav from './navigation'
import initHeader from './scroll'
import initHero from './hero'
import initInstagramFeed from './instagram'

function main() {
  // header
  initHeader()
  // nav
  initNav()
  // hero
  initHero()
  // initInstagramFeed()
  const elem = document.querySelector('.gm-instagram-feed');
  const flkty = new Flickity( elem,  {
    groupCells: true,
    on: {
      ready: () => {
        // hack for size height bug
        setTimeout(() => {
          flkty.resize();
        }, 1000);
      },
    },
  });

}
document.addEventListener('DOMContentLoaded', () => {
  main()
})
