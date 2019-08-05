/**
 * Создание DOM-элемента
 *
 * @param node тип создаваемого элемента
 * @param attributes список атрибутов
 * @returns {createElement} созданный элемент
 */
function createElement(node, attributes) {
    attributes = attributes || {};
    let element = document.createElement(node);
    element.textContent = ' Span ';
    if (attributes !== {}) {
        for (let attr in attributes) {
            element.setAttribute(attr, attributes[attr]);
        }
    }
    return element;
}