export const ImagePreview = ($containerElement) => {
  const dom = {
    container: $containerElement,
    fileInput: null,
    previewImage: null,
    uploadButton: null,
  }

  let isValid = false

  const initializeElements = () => {
    if (!dom.container) {
      console.error('ImagePreview: Container element is missing.')
      return false
    }

    dom.fileInput = dom.container.querySelector(
      'input[type="file"][data-preview-target]'
    )
    dom.previewImage = dom.container.querySelector('[data-preview-image]')
    dom.uploadButton = dom.container.querySelector('[data-upload-button]')

    if (!dom.fileInput || !dom.previewImage || !dom.uploadButton) {
      console.warn(
        'ImagePreview: Missing elements in container.',
        dom.container
      )
      return false
    }
    return true
  }

  /**
   * Updates the image visibility and button visibility/text
   * @param {boolean} isFileSelected
   */
  const updateUI = (isFileSelected) => {
    const hasExistingPhoto =
      dom.previewImage.dataset.originalSrc &&
      dom.previewImage.dataset.originalSrc !== '#'

    const changePhotoButton = dom.container.querySelector(
      '.a_Input-dog_button-change'
    )
    const choosePhotoButton = dom.container.querySelector(
      '.a_Input-dog_button-upload'
    )

    if (isFileSelected) {
      dom.previewImage.style.display = 'block'

      if (changePhotoButton) {
        changePhotoButton.style.display = 'block'
        changePhotoButton.textContent = 'Modifier la photo'
      }
      if (choosePhotoButton) {
        choosePhotoButton.style.display = 'none'
      }

      if (dom.uploadButton) {
        dom.uploadButton.textContent = 'Modifier la photo'
        dom.uploadButton.style.display = 'block'
      }
    } else {
      if (hasExistingPhoto) {
        dom.previewImage.style.display = 'block'
        dom.previewImage.src = dom.previewImage.dataset.originalSrc
        dom.previewImage.classList.add('existing-photo-preview')
        dom.previewImage.alt = 'Current photo preview'
        if (dom.uploadButton) {
          dom.uploadButton.textContent = 'Modifier la photo'
          dom.uploadButton.style.display = 'block'
        }
        if (choosePhotoButton) {
          choosePhotoButton.style.display = 'none'
        }
      } else {
        dom.previewImage.style.display = 'none'
        dom.previewImage.src = '#'
        if (dom.uploadButton) {
          dom.uploadButton.textContent = 'Choisir une photo'
          dom.uploadButton.style.display = 'block'
        }
        if (changePhotoButton) {
          changePhotoButton.style.display = 'none'
        }
      }
    }
  }

  const handleFileChange = (event) => {
    const file = event.target.files[0]

    if (file) {
      const reader = new FileReader()

      reader.onerror = (error) => {
        console.error('ImagePreview: FileReader error:', error)
        updateUI(false)
      }
      reader.onload = (e) => {
        dom.previewImage.src = e.target.result
        dom.previewImage.classList.remove('existing-photo-preview')
        dom.previewImage.alt = 'New photo preview'
        updateUI(true)
      }

      reader.readAsDataURL(file)
    } else {
      updateUI(false)
    }
  }
  const handleButtonClick = () => {
    dom.fileInput.click()
  }

  return {
    init: () => {
      isValid = initializeElements()
      if (!isValid) {
        return
      }
      dom.fileInput.addEventListener('change', handleFileChange)
      dom.uploadButton.addEventListener('click', handleButtonClick)

      updateUI(false)
    },
  }
}

export default ImagePreview
