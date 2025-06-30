document.addEventListener('DOMContentLoaded', () => {
  const menu = document.querySelector('.m_MobileMenu')
  const toggleButton = document.querySelector('.o_Navbar_links-mobileMenu')
  const closeButton = document.querySelector('.m_MobileMenu_close')

  if (!menu) return

  if (toggleButton) {
    toggleButton.addEventListener('click', () => {
      menu.classList.toggle('open')
    })
  }

  if (closeButton) {
    closeButton.addEventListener('click', () => {
      menu.classList.remove('open')
    })
  }
})
