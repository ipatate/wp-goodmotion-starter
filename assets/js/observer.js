function initObserver() {
  if(!window.IntersectionObserver){
    document.querySelectorAll('.gm-observe-me').forEach(e => e.classList.add('gm-is-inner'));
  }
  const observer = new IntersectionObserver((entry) =>
      entry.forEach(e => {
        if(e.isIntersecting) {
          e.target.classList.add('gm-is-inner')
          observer.unobserve(e.target)
        }
      })
    , {rootMargin: "0px 0px -100px 0px"});

  document.querySelectorAll('.gm-observe-me').forEach(img => {
    observer.observe(img)
  });
}

export default initObserver
