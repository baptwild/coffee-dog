import updateStatusText from '../utils/updateStatusText'

export const ToggleSwitchForm = ($containerElement) => {
  const dom = {
    container: $containerElement,
    visibleInput: $containerElement.querySelector('.js-toggle-input'),
    statusTextElement: $containerElement.nextElementSibling,
    hiddenInput: null,
  }

  let isValid = false

  const initializeElements = () => {
    if (!dom.container) {
      console.error('Container element is missing')
      return false
    }

    if (!dom.visibleInput || !dom.statusTextElement) {
      console.error('Missing elements', {
        container: dom.container,
        visibleInput: dom.visibleInput,
        statusTextElement: dom.statusTextElement,
      })
      return false
    }

    const hiddenInputId = dom.visibleInput.dataset.target
    dom.hiddenInput = document.querySelector(`#${hiddenInputId}`)

    if (!dom.hiddenInput) {
      console.error('Input not found for ID:', hiddenInputId)
      return false
    }

    return true
  }

  const handleClick = (event) => {
    event.preventDefault()

    dom.visibleInput.checked = !dom.visibleInput.checked

    updateStatusText(dom.statusTextElement, dom.visibleInput.checked)

    dom.hiddenInput.checked = dom.visibleInput.checked
  }

  return {
    init: () => {
      isValid = initializeElements()
      if (!isValid) {
        return
      }

      dom.visibleInput.checked = dom.hiddenInput.checked
      updateStatusText(dom.statusTextElement, dom.visibleInput.checked)

      dom.container.addEventListener('click', handleClick)
    },
  }
}

export default ToggleSwitchForm
