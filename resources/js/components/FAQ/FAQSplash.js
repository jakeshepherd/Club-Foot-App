import React from 'react';
import ReactDOM from 'react-dom';

import Question from "./Question";

class FAQSplash extends React.Component {
    render() {
        return (
            <div>
                <Question />
            </div>
        );
    }
}

export default FAQSplash;

if (document.getElementById('faq')) {
    ReactDOM.render(<FAQSplash />, document.getElementById('faq'));
}
