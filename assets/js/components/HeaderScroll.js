export const HeaderScroll = ($headerElement) => {
  const dom = {
    header: $headerElement,
    loginButton: null,
  }

  let isValid = false

  /**
   * Initializes DOM references and performs basic validation.
   * @returns {boolean}
   */
  const initializeElements = () => {
    if (!dom.header) {
      console.error(
        'HeaderScroll: Header element (.l_Header-transparent) is missing.'
      )
      return false
    }

    dom.loginButton = document.querySelector('.o_Navbar_login-button')
    if (!dom.loginButton) {
      console.error(
        'HeaderScroll: Login button (.o_Navbar_login-button) is missing.'
      )
      return false
    }

    return true
  }

  const toggleTransparency = () => {
    const scrolled = window.scrollY > 10

    dom.header.classList.toggle('l_Header-transparent', !scrolled)
    dom.loginButton.classList.toggle('a_Button-tertiary', !scrolled)
    dom.loginButton.classList.toggle('a_Button-primary', scrolled)
  }

  return {
    init: () => {
      isValid = initializeElements()
      if (!isValid) {
        return
      }

      window.addEventListener('scroll', toggleTransparency)
      toggleTransparency()
    },
  }
}

export default HeaderScroll
