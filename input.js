export default class Input {
  constructor(element, errorElement, isRequired) {
    this._element = element;
    this._errorElement = errorElement;
    this._defaultValue = this._element.value;
    this._errorValue = "";
    this._isRequired = isRequired;
    this._hasTouched = false;

    this.addListeners();
  }

  addListeners() {
    this._element.addEventListener("focus", () => {
      this._hasTouched = true;

      if (this._element.value == this._defaultValue) {
        this._element.value = "";
      }
    });

    this._element.addEventListener("blur", () => {
      if (this.isEmpty() && this._hasTouched) {
        this.showError();
      }

      if (this._element.value == "") {
        this._element.value = this._defaultValue;
      }
    });

    this._element.addEventListener("change keyup", () => {
      if (!this.isEmpty()) {
        this.hideError();
      }
    });
  }

  isEmpty() {
    if (!this._isRequired) {
      return false;
    }

    if (this._element.value == this._defaultValue) {
      return true;
    }

    return false;
  }

  getValue() {
    if (this._element.value == this._defaultValue) {
      return "";
    }

    return this._element.value;
  }

  showError() {
    if (!this._isRequired) {
      return;
    }

    this._element.addClass("error");

    // if( this._errorElement ) {
    console.log(this._errorElement);
    this._errorElement.addClass("error");
    // }
  }

  hideError() {
    this._element.removeClass("error");

    if (this._errorElement) {
      this._errorElement.removeClass("error");
    }
  }
}
