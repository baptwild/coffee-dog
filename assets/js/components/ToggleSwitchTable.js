import updateStatusText from '../utils/updateStatusText'

export const ToggleSwitchTable = ($containerElement) => {
  const dom = {
    container: $containerElement,
    visibleInput: $containerElement.querySelector('.js-toggle-input'),
    statusTextElement: null,
  }

  // 2. Internal state (props)
  let bookingId = null
  let toggleUrl = null
  let csrfToken = null
  let isValid = false

  const initializeElementsAndData = () => {
    if (!dom.container) {
      console.error('ToggleSwitchTable: Container element is missing.')
      return false
    }

    if (!dom.visibleInput) {
      console.error('ToggleSwitchTable: Missing visible input element.', {
        container: dom.container,
      })
      return false
    }

    bookingId = dom.visibleInput.dataset.bookingId
    toggleUrl = dom.visibleInput.dataset.toggleUrl
    csrfToken = dom.visibleInput.dataset.csrfToken

    if (!bookingId || !toggleUrl || !csrfToken) {
      console.error(
        'ToggleSwitchTable: Missing data attributes on toggle input.',
        {
          visibleInput: dom.visibleInput,
          bookingId,
          toggleUrl,
          csrfToken,
        }
      )
      return false
    }

    dom.statusTextElement = document.querySelector(
      `p[data-booking-status-text="${bookingId}"]`
    )
    if (!dom.statusTextElement) {
      console.error(
        'ToggleSwitchTable: Missing status text element for booking ID:',
        bookingId
      )
      return false
    }

    return true
  }

  const handleClick = (event) => {
    event.preventDefault()

    const oldIsActive = dom.visibleInput.checked
    dom.visibleInput.checked = !oldIsActive
    updateStatusText(dom.statusTextElement, dom.visibleInput.checked)

    const newIsActive = dom.visibleInput.checked
    const formData = new FormData()
    formData.append('is_active', newIsActive ? '1' : '0')
    formData.append('_token', csrfToken)

    fetch(toggleUrl, {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      },
    })
      .then((response) => {
        if (!response.ok) {
          return response.json().then((err) => {
            console.error('Server error response:', err)
            return Promise.reject(err.message || 'Unknown server error')
          })
        }
        return response.json()
      })
      .then((data) => {
        if (data.status === 'success') {
        } else {
          console.error('Server reported non-success status:', data.message)
          dom.visibleInput.checked = oldIsActive
          updateStatusText(dom.statusTextElement, oldIsActive)
          alert(
            'Erreur lors de la mise à jour: ' +
              (data.message || 'Vérifiez la console.')
          )
        }
      })
      .catch((error) => {
        console.error('AJAX request failed:', error)
        dom.visibleInput.checked = oldIsActive
        updateStatusText(dom.statusTextElement, oldIsActive)
        alert(
          'Erreur réseau ou du serveur. Veuillez réessayer. Détails: ' + error
        )
      })
  }

  return {
    init: () => {
      isValid = initializeElementsAndData()
      if (!isValid) {
        return
      }

      updateStatusText(dom.statusTextElement, dom.visibleInput.checked)

      dom.container.addEventListener('click', handleClick)
    },
  }
}

export default ToggleSwitchTable
