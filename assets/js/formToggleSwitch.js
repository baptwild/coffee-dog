const initFormToggleSwitch = () => {
  const formToggleContainers = document.querySelectorAll(
    '.js-form-toggle-container'
  )

  formToggleContainers.forEach((container) => {
    const visibleInput = container.querySelector('.js-toggle-input')
    const slider = container.querySelector('.slider')
    const statusTextElement = container.nextElementSibling

    if (!visibleInput || !slider) {
      console.error('Input or slider missing for switch: ', container)
      return
    }

    const targetInputId = visibleInput.dataset.target

    if (!targetInputId) {
      console.error('Missing data attributes on input: ', visibleInput)
      return
    }

    const hiddenInput = document.querySelector(`#${targetInputId}`)

    if (!hiddenInput) {
      console.error('Input not found for ID:', targetInputId)
      return
    }

    visibleInput.checked = hiddenInput.checked
    updateStatusText(statusTextElement, visibleInput.checked)

    container.addEventListener('click', (event) => {
      event.preventDefault()

      visibleInput.checked = !visibleInput.checked
      updateStatusText(statusTextElement, visibleInput.checked)

      visibleInput.dispatchEvent(new Event('change', { bubbles: true }))
    })

    visibleInput.addEventListener('change', () => {
      hiddenInput.checked = visibleInput.checked
    })
  })
}

const updateStatusText = (element, isActive) => {
  if (element) {
    element.textContent = isActive ? '✅ Active' : '⛔️ Inactive'
  }
}

document.addEventListener('DOMContentLoaded', initFormToggleSwitch)
document.addEventListener('turbo:load', initFormToggleSwitch)
