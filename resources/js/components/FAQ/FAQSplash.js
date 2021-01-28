import React from 'react';
import ReactDOM from 'react-dom';

class FAQSplash extends React.Component {
    constructor(props) {
        super(props);
        this.state = {}
    }

    render() {
        return (
            <div>
                This is FAQ
            </div>
        );
    }
}

export default FAQSplash;

if (document.getElementById('faq')) {
    ReactDOM.render(<FAQSplash />, document.getElementById('faq'));
}
