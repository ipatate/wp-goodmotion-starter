import axios from 'axios'

const initInstagramFeed = async () => {
  return
  const instagramContainer = document.querySelectorAll('.gm-instagram-feed')
  if (instagramContainer.length === 0) return
  const { data } = await axios.get('/wp-json/gm-instagram-connect/feed')
  if (!data.data) return
  const container = document.createElement('div')
  container.classList.add('gm-instagram-feed-container')
  data.data.forEach((e) => {
    if (e.media_type === 'VIDEO') {
      container.appendChild(createImage(e, 'video'))
    }
    if (e.media_type === 'IMAGE') {
      container.appendChild(createImage(e))
    }
  })
  instagramContainer[0].removeChild(instagramContainer[0].childNodes[0])
  instagramContainer[0].appendChild(container)
}

const createVideo = (e) => {
  const container = document.createElement('div')
  const video = document.createElement('video')
  const source = document.createElement('source')
  source.src = e.media_url
  video.appendChild(source)
  container.appendChild(video)
  return container
}

const createImage = (e, type = 'image') => {
  const container = document.createElement('div')
  container.classList.add('gm-instagram-feed-element')
  const image = document.createElement('img')
  image.src = type === 'image' ? e.media_url : e.thumbnail_url
  image.setAttribute('loading', 'lazy')
  const a = document.createElement('a')
  a.href = e.permalink
  a.setAttribute('target', '_blank')
  a.setAttribute('rel', 'nofollow')
  a.appendChild(image)
  container.appendChild(a)
  container.appendChild(createInfo(e))
  return container
}

const createInfo = (e) => {
  const container = document.createElement('div')
  container.classList.add('gm-instagram-feed-element-info')
  const p = document.createElement('p')
  p.innerHTML = e.caption
  const p_user = document.createElement('p')
  p_user.innerHTML = `@${e.username}`
  container.appendChild(p)
  // container.appendChild(p_user)
  return container
}

export default initInstagramFeed
