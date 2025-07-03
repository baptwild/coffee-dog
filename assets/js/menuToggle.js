const initMobileMenu = () => {
  const menu = document.querySelector('.m_MobileMenu')
  const toggleButton = document.querySelector('.o_Navbar_links-mobileMenu')
  const closeButton = document.querySelector('.m_MobileMenu_close')

  if (!menu || !toggleButton || !closeButton) {
    return
  }

  toggleButton.onclick = () => {
    menu.classList.toggle('open')
  }

  closeButton.onclick = () => {
    menu.classList.remove('open')
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initMobileMenu)
} else {
  initMobileMenu()
}

document.addEventListener('turbo:load', initMobileMenu)
