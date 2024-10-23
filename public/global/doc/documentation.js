export class Documentation {
    static generate(componentName, description, usage, htmlStructure, attributes, functionality, customFunctions = null) {
        return `
<div class="devToolDocumentation">
    <h2 class="componentTitle">${componentName}</h2>
    <div class="componentDescription">${description}</div>

    <h3>📘 Usage</h3>
    <pre><code class="language-javascript">${this.escapeHtml(usage)}</code></pre>

    <h3>🏗️ HTML Structure</h3>
    <pre><code class="language-html">${this.escapeHtml(htmlStructure)}</code></pre>

    <h3>🔧 Attributes</h3>
    <table class="devToolTable">
        <thead>
            <tr>
                <th>Attribute</th>
                <th>Description</th>
                <th>Required</th>
                <th>Default</th>
            </tr>
        </thead>
        <tbody>
            ${attributes.map(attr => `
                <tr>
                    <td><code>${attr.name}</code></td>
                    <td>${attr.description}</td>
                    <td>${attr.required ? '✅ Yes' : '❌ No'}</td>
                    <td>${attr.default !== undefined ? `<code>${attr.default}</code>` : 'N/A'}</td>
                </tr>
            `).join('')}
        </tbody>
    </table>

    <h3>🚀 Functionality</h3>
    <ul class="functionalityList">
        ${functionality.map(item => `<li>${item}</li>`).join('')}
    </ul>

    ${customFunctions ? `
    <h3>🎛️ Custom Functions</h3>
    <div class="customFunctionsDescription">
        Custom functions allow you to extend the behavior of the ${componentName}.
        They are called when the counter is incremented or decremented, giving you full control over the counter's behavior.
    </div>
    <pre><code class="language-javascript">${this.escapeHtml(customFunctions)}</code></pre>
    ` : ''}

    <style>
        .devToolDocumentation {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .componentTitle {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .componentDescription {
            font-size: 1.1em;
            color: #34495e;
            margin-bottom: 20px;
        }
        .devToolDocumentation h3 {
            color: #2980b9;
            margin-top: 30px;
            font-size: 1.8em;
        }
        .devToolDocumentation pre {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            overflow-x: auto;
            margin: 15px 0;
        }
        .devToolDocumentation code {
            font-family: 'Courier New', Courier, monospace;
            color: #e74c3c;
        }
        .devToolTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .devToolTable th, .devToolTable td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .devToolTable th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }
        .devToolTable tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .functionalityList {
            padding-left: 20px;
            list-style-type: none;
        }
        .functionalityList li {
            margin-bottom: 10px;
            position: relative;
        }
        .functionalityList li::before {
            content: '✓';
            color: #2ecc71;
            position: absolute;
            left: -20px;
        }
        .customFunctionsDescription {
            background-color: #e8f6f3;
            border-left: 4px solid #1abc9c;
            padding: 10px;
            margin-bottom: 15px;
        }
        .copyButton {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            float: right;
            transition: background-color 0.3s;
        }
        .copyButton:hover {
            background-color: #2980b9;
        }
    </style>

    <script>
        function addCopyButtons() {
            const codeBlocks = document.querySelectorAll('.devToolDocumentation pre code');
            codeBlocks.forEach((codeBlock, index) => {
                const button = document.createElement('button');
                button.textContent = 'Copy';
                button.className = 'copyButton';
                button.onclick = function() {
                    const code = codeBlock.textContent;
                    navigator.clipboard.writeText(code).then(() => {
                        button.textContent = 'Copied!';
                        setTimeout(() => {
                            button.textContent = 'Copy';
                        }, 2000);
                    });
                };
                codeBlock.parentNode.insertBefore(button, codeBlock);
            });
        }
        addCopyButtons();
    </script>
</div>
        `;
    }

    static escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
}
