document.addEventListener('DOMContentLoaded', () => {
  const header = document.querySelector('.l_Header-transparent')

  if (!header) return

  const toggleTransparency = () => {
    if (window.scrollY > 10) {
      header.classList.remove('l_Header-transparent')
    } else {
      header.classList.add('l_Header-transparent')
    }
  }

  window.addEventListener('scroll', toggleTransparency)

  toggleTransparency()
})
