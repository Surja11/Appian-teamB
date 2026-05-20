class global {
    constructor() {
        this.events();
    }

    events() {
       console.log('global');
    }
}

export default global;
new global();
