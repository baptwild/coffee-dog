const initHeaderTransparency = () => {
  const header = document.querySelector('.l_Header-transparent')
  const loginButton = document.querySelector('.o_Navbar_login-button')

  if (!header || !loginButton) return

  const toggleTransparency = () => {
    const scrolled = window.scrollY > 10

    header.classList.toggle('l_Header-transparent', !scrolled)
    loginButton.classList.toggle('a_Button-tertiary', !scrolled)
    loginButton.classList.toggle('a_Button-primary', scrolled)
  }

  window.addEventListener('scroll', toggleTransparency)
  toggleTransparency()
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initHeaderTransparency)
} else {
  initHeaderTransparency()
}

document.addEventListener('turbo:load', initHeaderTransparency)
