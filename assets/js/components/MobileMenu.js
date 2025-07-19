export const MobileMenu = ($menuElement) => {
  const dom = {
    menu: $menuElement,
    toggleButton: null,
    closeButton: null,
  }

  let isValid = false

  /**
   * Initializes DOM references and performs basic validation.
   * @returns {boolean}
   */
  const initializeElements = () => {
    if (!dom.menu) {
      console.error('MobileMenu: Menu element (.m_MobileMenu) is missing.')
      return false
    }

    dom.toggleButton = document.querySelector('.m_MobileMenu_open')
    dom.closeButton = document.querySelector('.m_MobileMenu_close')

    if (!dom.toggleButton || !dom.closeButton) {
      console.error('MobileMenu: Toggle or close button is missing.', {
        toggleButton: dom.toggleButton,
        closeButton: dom.closeButton,
      })
      return false
    }

    return true
  }

  const handleToggleClick = () => {
    dom.menu.classList.toggle('open')
  }

  const handleCloseClick = () => {
    dom.menu.classList.remove('open')
  }

  return {
    init: () => {
      isValid = initializeElements()
      if (!isValid) {
        return
      }

      dom.toggleButton.addEventListener('click', handleToggleClick)
      dom.closeButton.addEventListener('click', handleCloseClick)
    },
  }
}

export default MobileMenu
