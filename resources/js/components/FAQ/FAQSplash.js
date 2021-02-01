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
                <Question name={"Skin Issues"} image={skin}
                          FAQs={[
                              {
                                  question: 'My child has blisters',
                                  answer: 'Blistering is often a sign that the Boots and Bars are not fitting properly! ' +
                                      'Please call your local practice and we will try and help.'
                              },
                              {
                                  question: 'My child has a rash',
                                  answer: 'A rash could mean that there is rubbing on your Boots and Bars, ' +
                                      'please let us know by calling your local practice.'
                              }
                          ]}
                />
                <Question name={"Clothing"} image={clothing}
                          FAQs={[
                              {
                                  question: 'Are there any good clothes to wear with the boots?',
                                  answer: 'Try this website: www.example.com'
                              },
                          ]}/>
                <Question name={"Brace Advice"} image={boot}
                          FAQs={[
                              {
                                  question: 'How do I put on the boots and bars?',
                                  answer: 'Take a look at this video!'
                              },
                              {
                                  question: 'How long should my child wear the boots and bars for?',
                                  answer: 'For the first 3 months your child should wear the boots for 23 hours a day. ' +
                                      'After this, your child only needs to wear them between 12 and 14 hours a day'
                              }
                          ]}/>
            </div>
        );
    }
}

export default FAQSplash;

if (document.getElementById('faq')) {
    ReactDOM.render(<FAQSplash/>, document.getElementById('faq'));
}
