import React from 'react';
import ReactDOM from 'react-dom';

import Question from "./Question";
import skin from '../../../images/icons8-skin-80.png';

class FAQSplash extends React.Component {
    render() {
        return (
            <div>
                <Question name={"Skin Issues"} image={skin}/>
            </div>
        );
    }
}

export default FAQSplash;

if (document.getElementById('faq')) {
    ReactDOM.render(<FAQSplash />, document.getElementById('faq'));
}
