export const TextImageBlockReveal = ($containerElement) => {
  const dom = {
    container: $containerElement,
    button: null,
    hiddenDescription: null,
  }

  let isValid = false

  /**
   * Initializes DOM references and performs basic validation.
   * @returns {boolean}
   */
  const initializeElements = () => {
    if (!dom.container) {
      console.error('TextImageBlockReveal: Container element is missing.')
      return false
    }

    dom.button = dom.container.querySelector('.m_TextImageBlock_button')
    dom.hiddenDescription = dom.container.querySelector(
      '.m_TextImageBlock_description.hidden'
    )

    if (!dom.button || !dom.hiddenDescription) {
      console.warn(
        'TextImageBlockReveal: Missing required sub-elements or description is not initially hidden within container.',
        {
          container: dom.container,
          button: dom.button,
          hiddenDescription: dom.hiddenDescription,
        }
      )
      return false
    }

    return true
  }

  const handleClick = () => {
    if (dom.hiddenDescription) {
      dom.hiddenDescription.classList.remove('hidden')
      dom.hiddenDescription.classList.add('visible')
    }
    if (dom.button) {
      dom.button.style.display = 'none'
    }
  }

  return {
    init: () => {
      isValid = initializeElements()
      if (!isValid) {
        return
      }
      dom.button.addEventListener('click', handleClick)
    },
  }
}

export default TextImageBlockReveal
