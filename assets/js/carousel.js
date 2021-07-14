import Flickity from 'flickity'

function initCarousel()
{

  const elements = document.getElementsByClassName('gm-carousel-grouped');
  const flick = [];
  if(elements && elements.length > 0) {
    for (const element of elements) {
      console.log(element)
      flick[element] = new Flickity(element, {
      groupCells: true,
      on: {
        ready: () => {
          // hack for size height bug
          setTimeout(() => {
            flick[element].resize();
          }, 1000);
        },
      }
    });
  }
  }

}

export default initCarousel
