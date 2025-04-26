import { getComponentPath } from "@filamentphp/support";

document.addEventListener("alpine:init", () => {
    Alpine.data("dynamicComponent", (component) => ({
        component: component,

        init() {
            this.component = getComponentPath(component);
        },
    }));
});
