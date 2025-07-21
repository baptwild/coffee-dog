export const MessageModal = ($containerElement) => {
  const dom = {
    container: $containerElement,
  }
  let isValid = false
  let flashMessages = {}

  /**
   * Initializes DOM references and extracts flash messages from data attribute.
   * @returns {boolean}
   */
  const initializeElements = () => {
    if (!dom.container) {
      return false
    }

    const rawFlashMessages = dom.container.dataset.flashMessages
    if (rawFlashMessages) {
      try {
        flashMessages = JSON.parse(rawFlashMessages)
        dom.container.dataset.flashMessages = '[]'
      } catch (e) {
        console.error(
          'FlashMessageModal: Error parsing flash messages JSON:',
          e
        )
        flashMessages = {}
      }
    } else {
      flashMessages = {}
    }

    const hasMessages = Object.keys(flashMessages).length > 0
    if (!hasMessages) {
      return false
    }
    return true
  }

  /**
   * Creates and displays a single modal for a flash message.
   * @param {object} flash
   */
  const createAndDisplayModal = (flash) => {
    const modalOverlay = document.createElement('div')
    modalOverlay.classList.add('m_Modal_overlay')

    const modalContent = document.createElement('div')
    modalContent.classList.add('m_Modal_content')

    const closeButton = document.createElement('i')
    closeButton.classList.add('m_Modal_close', 'bi', 'bi-x-lg')
    closeButton.addEventListener('click', () => {
      modalOverlay.classList.remove('show')
      modalOverlay.addEventListener(
        'transitionend',
        () => {
          modalOverlay.remove()
        },
        { once: true }
      )
    })

    const messageParagraph = document.createElement('p')

    messageParagraph.classList.add('m_Modal_message', flash.type)
    messageParagraph.textContent = flash.message

    modalContent.appendChild(closeButton)
    modalContent.appendChild(messageParagraph)
    modalOverlay.appendChild(modalContent)
    dom.container.appendChild(modalOverlay)

    setTimeout(() => {
      modalOverlay.classList.add('show')
    }, 50)
  }

  return {
    init: () => {
      isValid = initializeElements()
      if (!isValid) {
        return
      }

      Object.keys(flashMessages).forEach((type) => {
        const messagesOfType = flashMessages[type]

        messagesOfType.forEach((message) => {
          createAndDisplayModal({ type: type, message: message })
        })
      })
    },
  }
}

export default MessageModal
