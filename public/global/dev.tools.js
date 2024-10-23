export class DevTools {
    static componentMap;
    static initializedComponents;
    static devToolsContainer;

    static init(componentMap, initializedComponents) {
        this.componentMap = componentMap;
        this.initializedComponents = initializedComponents;
        this.createDevToolsUI();
        this.setupDevTools();
    }

    static createDevToolsUI() {
        const devToolsHTML = `
            <div id="devToolContainer" class="devToolContainer">
                <div class="devToolHeader">
                    <h3>🛠️ Dev Tools</h3>
                    <button id="devToolToggle" class="devToolToggle">▲</button>
                </div>
                <div class="devToolContent">
                    <div class="devToolTabs">
                        <button class="devToolTabButton active" data-tab="components">Components</button>
                        <button class="devToolTabButton" data-tab="identifiers">Identifiers</button>
                        <button class="devToolTabButton" data-tab="documentation">Documentation</button>
                    </div>
                    <div class="devToolTabContent active" id="devToolComponentsTab">
                        <div class="devToolSection">
                            <h4>Available Components</h4>
                            <ul id="devToolAvailableComponents" class="devToolList"></ul>
                        </div>
                        <div class="devToolSection">
                            <h4>Initialized Components</h4>
                            <ul id="devToolInitializedComponents" class="devToolList"></ul>
                        </div>
                    </div>
                    <div class="devToolTabContent" id="devToolIdentifiersTab">
                        <div class="devToolSection">
                            <h4>Used Identifiers</h4>
                            <ul id="devToolUsedIdentifiers" class="devToolList"></ul>
                        </div>
                    </div>
                    <div class="devToolTabContent" id="devToolDocumentationTab">
                        <div class="devToolSection">
                            <select id="devToolDocSelector" class="devToolSelect"></select>
                            <div id="devToolDocumentation" class="devToolDocumentation"></div>
                        </div>
                    </div>
                </div>
            </div>
        `;


        const devToolsContainer = document.createElement('div');
        devToolsContainer.innerHTML = devToolsHTML;
        document.body.appendChild(devToolsContainer);

        this.devToolsContainer = devToolsContainer;

        this.setupEventListeners();
        this.updateDevToolsContent();
    }

    static setupEventListeners() {
        const toggleButton = document.getElementById('devToolToggle');
        const content = this.devToolsContainer.querySelector('.devToolContent');

        toggleButton.addEventListener('click', () => {
            content.style.display = content.style.display === 'none' ? 'block' : 'none';
            toggleButton.textContent = content.style.display === 'none' ? '▼' : '▲';
        });

        const tabButtons = this.devToolsContainer.querySelectorAll('.devToolTabButton');
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                const tabContents = this.devToolsContainer.querySelectorAll('.devToolTabContent');
                tabContents.forEach(content => content.classList.remove('active'));
                const tabContent = this.devToolsContainer.querySelector(`#devTool${button.dataset.tab.charAt(0).toUpperCase() + button.dataset.tab.slice(1)}Tab`);
                tabContent.classList.add('active');
            });
        });
    }

    static updateDevToolsContent() {
        const availableComponents = document.getElementById('devToolAvailableComponents');
        const usedIdentifiers = document.getElementById('devToolUsedIdentifiers');
        const initializedComponents = document.getElementById('devToolInitializedComponents');
        const docSelector = document.getElementById('devToolDocSelector');

        availableComponents.innerHTML = Object.keys(this.componentMap).map(id => `<li>${id}</li>`).join('');
        usedIdentifiers.innerHTML = Array.from(this.getUsedIdentifiers()).map(id => `<li>${id}</li>`).join('');
        initializedComponents.innerHTML = Array.from(this.initializedComponents).map(id => `<li>${id}</li>`).join('');

        docSelector.innerHTML = `<option value="">Select a component</option>` +
            Object.keys(this.componentMap).map(id => `<option value="${id}">${id}</option>`).join('');

        docSelector.addEventListener('change', (e) => {
            const documentation = document.getElementById('devToolDocumentation');
            const selectedComponent = e.target.value;
            if (selectedComponent) {
                documentation.innerHTML = this.getDocumentation(selectedComponent);
                // Re-run the script to add copy buttons
                const script = documentation.querySelector('script');
                if (script) {
                    eval(script.textContent);
                }
            } else {
                documentation.innerHTML = '';
            }
        });
    }

    static setupDevTools() {
        window.devTools = {
            getDocumentation: this.getDocumentation.bind(this),
            listAvailableComponents: this.listAvailableComponents.bind(this),
            listUsedIdentifiers: this.listUsedIdentifiers.bind(this),
            showInitializedComponents: this.showInitializedComponents.bind(this)
        };

        window.devToolsHelp = this.devToolsHelp.bind(this);

        console.log("Development mode: Dev tools available. Use devToolsHelp() to see all available functions.");
    }

    static getDocumentation(identifier) {
        const Component = this.componentMap[identifier];
        if (Component && typeof Component.documentation === 'function') {
            return Component.documentation();
        } else {
            return `No documentation found for identifier: ${identifier}`;
        }
    }

    static listAvailableComponents() {
        console.log("Available components:");
        Object.keys(this.componentMap).forEach(identifier => {
            console.log(`- ${identifier}`);
        });
    }

    static getUsedIdentifiers() {
        const usedIdentifiers = new Set();
        Object.keys(this.componentMap).forEach(identifier => {
            if (document.querySelector(`[identifier="${identifier}"]`)) {
                usedIdentifiers.add(identifier);
            }
        });
        return usedIdentifiers;
    }

    static listUsedIdentifiers() {
        console.log("Identifiers used on this page:");
        this.getUsedIdentifiers().forEach(identifier => console.log(`- ${identifier}`));
    }

    static showInitializedComponents() {
        console.log("Initialized components on this page:");
        this.initializedComponents.forEach(identifier => console.log(`- ${identifier}`));
    }

    static devToolsHelp() {
        console.log("Available Development Tools:");
        console.log("- devTools.getDocumentation(identifier): View documentation for a specific component");
        console.log("- devTools.listAvailableComponents(): List all available component identifiers");
        console.log("- devTools.listUsedIdentifiers(): List identifiers used on the current page");
        console.log("- devTools.showInitializedComponents(): Show components initialized on the current page");
        console.log("\nExample usage: devTools.getDocumentation('simple-counter-component')");
    }
}
