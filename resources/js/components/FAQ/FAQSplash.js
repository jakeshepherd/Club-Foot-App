import React from 'react';
import ReactDOM from 'react-dom';

import Question from "./Question";
import skin from '../../../images/icons8-skin-80.png';
import clothing from '../../../images/icons8-jumper-128.png';
import boot from '../../../images/icons8-work-boot-64.png';

class FAQSplash extends React.Component {
    render() {
        return (
            <div>
                <Question name={"Skin Issues"} image={skin}/>
                <Question name={"Clothing"} image={clothing}/>
                <Question name={"Brace Advice"} image={boot}/>
            </div>
        );
    }
}

export default FAQSplash;

if (document.getElementById('faq')) {
    ReactDOM.render(<FAQSplash/>, document.getElementById('faq'));
}
