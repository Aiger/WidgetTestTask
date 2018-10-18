(function (global) {
    var colorSets = [
        {
            name: 'Синяя',
            colors: {
                text: '#33323a',
                middle: '#777882',
                bg: '#fff',
                buttonText: '#fff',
                buttonBG: '#397ecc',
                link: '#397ecc'
            }
        },
        {
            name: 'Зелёная',
            colors: {
                text: '#212a24',
                middle: '#77877b',
                bg: '#fff',
                buttonText: '#fff',
                buttonBG: '#27ae60',
                link: '#27ae60'
            }
        },
        {
            name: 'Красная',
            colors: {
                text: '#2b1917',
                middle: '#907677',
                bg: '#fff',
                buttonText: '#fff',
                buttonBG: '#cc2a18',
                link: '#cc2a18'
            }
        },
        {
            name: 'Ночная',
            colors: {
                text: '#fff',
                middle: '#7a868d',
                bg: '#131b24',
                buttonText: '#fff',
                buttonBG: '#3e9bcc',
                link: '#3e9bcc'
            }
        },
        {
            name: 'Хаос',
            colors: {
                text: makeRandomColor(),
                middle: makeRandomColor(),
                bg: makeRandomColor(),
                buttonText: makeRandomColor(),
                buttonBG: makeRandomColor(),
                link: makeRandomColor()
            }
        }
    ];

    function makeRandomColor() {
        return '#' + ['', '', '', '', '', '']
            .map(function () {
                return (Math.trunc(Math.random() * 16)).toString(16);
            })
            .join('');
    }

    function installColorSets(colorSets) {
        var classNames = [];
        var style = document.createElement('style');
        style.textContent = colorSets
            .map(function (colorSet, index) {
                var className = 'env__colorSet-' + Math.trunc(Math.random() * 100000);
                classNames[index] = className;

                return Object.keys(colorSet.colors)
                    .map(function (colorName) {
                        return ['color', 'background-color', 'border-color']
                            .map(function (property) {
                                return "." + className + " ." + property + "-" + colorName
                                    + ", ." + className + " .enforce-selector ." + property + "-" + colorName
                                    + ", ." + className + " .enforce-selector .enforce-selector ." + property + "-" + colorName
                                    + " {\n\t" + property + ": " + colorSet.colors[colorName] + ";\n}";
                            })
                            .join("\n");
                    })
                    .join("\n")
            })
            .join("\n");

        document.head.appendChild(style);
        return classNames;
    }

    function livenFontSizeInput() {
        var fontSizeTarget = document.body;
        var inputElement = document.querySelector('#envConfig input[name="fontSize"]');

        function handleChange() {
            fontSizeTarget.style.fontSize = inputElement.value + 'px';
        }

        inputElement.addEventListener('input', handleChange);
        handleChange();
    }

    function livenColorSelect(colorSets) {
        var colorSetTarget = document.body;
        var colorsListElement = document.querySelector('#envConfig .app__colors-list');
        var colorSetClasses = installColorSets(colorSets);
        var currentColorSetIndex;

        function applyColorSet(index) {
            if (index === currentColorSetIndex) {
                return;
            }

            if (currentColorSetIndex !== undefined) {
                colorSetTarget.classList.remove(colorSetClasses[currentColorSetIndex]);
            }
            if (index !== undefined) {
                colorSetTarget.classList.add(colorSetClasses[index]);
            }

            currentColorSetIndex = index;
        }

        colorSets.forEach(function (colorSet, index) {
            var colorRadioButton = document.createElement('input');
            colorRadioButton.type = 'radio';
            colorRadioButton.name = 'colorSet';
            colorRadioButton.value = index;
            colorRadioButton.checked = index === 0;
            colorRadioButton.addEventListener('change', applyColorSet.bind(null, index));

            var listItemElement = document.createElement('label');
            listItemElement.appendChild(colorRadioButton);
            listItemElement.appendChild(document.createTextNode(' ' + colorSet.name));
            colorsListElement.appendChild(listItemElement);
        });
    }

    function livenWidgetOutput() {
        var outputElement = document.querySelector('.app__widget-output');

        global.app = {
            setWidgetOutput: function (output) {
                outputElement.classList.remove('app__widget-output_error');

                try {
                    var outputString;
                    if (output === undefined) {
                        outputString = 'undefined';
                    } else if (typeof output === 'number' && isNaN(output)) {
                        outputString = 'NaN';
                    } else if (output === Infinity) {
                        outputString = 'Infinity';
                    } else if (output === -Infinity) {
                        outputString = '-Infinity';
                    } else {
                        outputString = JSON.stringify(output, null, 2);
                    }

                    outputElement.textContent = outputString;
                } catch (error) {
                    outputElement.textContent = error;
                    outputElement.classList.add('app__widget-output_error');
                }
            }
        };
    }

    livenFontSizeInput();
    livenColorSelect(colorSets);
    livenWidgetOutput();
})(this);
