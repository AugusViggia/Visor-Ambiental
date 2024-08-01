export default function Errors () {
  function getErrorMessage (errorMessage) {
    if (typeof errorMessage === 'object') {
      return errorMessage[0]
    }
    return errorMessage
  }

  return {
    getErrorMessage,
  }
}
