import React from 'react';
import ReactDOM from 'react-dom';

import Question from "./Question";
import skin from '../../../images/icons8-skin-80.png';
import clothing from '../../../images/icons8-jumper-128.png';
import boot from '../../../images/icons8-work-boot-64.png';
import foot from '../../../images/icons8-foot-64.png';

import QuestionWithVideo from "./QuestionWithVideo";

class FAQSplash extends React.Component {
    render() {
        return (
            <div>
                <h1 className="w-4/5 md:w-1/2 text-center m-2 ml-auto mr-auto">For more information, please visit the 
                    <a className="text-blue-600" href="https://www.nhs.uk/conditions/club-foot/"> NHS website </a>
                    and <a className="text-blue-600" href="https://www.stepsworldwide.org/conditions/talipes-clubfoot/">
                        Steps Worldwide</a>
                </h1>
                <QuestionWithVideo name={"Brace Advice"} image={boot}
                                   FAQs={[
                                       {
                                           question: 'How long should my child wear the boots and bars for?',
                                           answer: 'Initially boots and bars are worn for 23 out of 24 hours for ' +
                                               'the first 3 months, after which, if your Physiotherapist is happy with ' +
                                               'the correction, you can drop down to night and nap time, aiming for 14 to 16 hours ' +
                                               'per day until the age of 5. ' +
                                               'It is important that a good bedtime regime is established early, ' +
                                               'as this will ensure your child goes happily into boots each night. ' +
                                               'A good way to remember is the 5 B’s:  Bath, Boots, Breast/Bottle, ' +
                                               'Book and Bed!\n'
                                       },
                                       {
                                           question: 'My child is outgrowing their boots',
                                           answer: 'When your child\'s toes reach the end of the boot, ' +
                                               'contact your Physiotherapist to arrange an appointment to have ' +
                                               'the next size boots fitted.'
                                       },
                                       {
                                           question: 'Bar Padding',
                                           answer: 'If you pad the bar you can help protect your child. ' +
                                               'You can use any kind of fabric that will act as a bumper.'
                                       }
                                   ]}/>
                <Question name={"Clothing"} image={clothing}
                          FAQs={[
                              {
                                  question: 'Can my baby wear clothes after the casting?',
                                  answer: 'To enable the cast to dry thoroughly your baby shouldn\'t wear trousers or a sleepsuit ' +
                                      'for the first 24 hours, so don\'t forget to bring a vest and a blanket to keep your baby warm.'
                              },
                              {
                                  question: 'Sock advice',
                                  answer: 'It is best to wear socks that have grip on the bottom, to stop the boots from slipping.'
                              },
                          ]}
                />
                <Question name={"Change in Foot Shape"} image={foot}
                          FAQs={[
                              {
                                  question: '',
                                  answer: 'If you notice the following things, you should contact your physiotherapist for advice.'
                              },
                              {
                                  question: '',
                                  answer: 'You may notice the arch of the foot is beginning to look more pronounced'
                              },
                              {
                                  question: '',
                                  answer: 'Your child may be putting more weight on the outside of the sole of their foot'
                              }
                          ]}/>
                <Question name={"Skin Issues"} image={skin}
                          FAQs={[
                              {
                                  question: 'My child has blisters',
                                  answer: 'It is not normal to get blisters or rubbing on the back of the heel. ' +
                                      'Check that the boots are on correctly and contact your Physiotherapist. ' +
                                      'You should check to make sure that you are placing the heel to the back of the boot ' +
                                      ' and that the middle strap is done up firmly enough.'
                              },
                              {
                                  question: 'My child\'s foot is swelling',
                                  answer: 'It is also normal for the area between the middle and toe straps ' +
                                      'to look swollen; this is not swelling but due to the soft tissue distribution ' +
                                      'in your baby’s feet.'
                              },
                              {
                                  question: 'There is redness on my child\'s foot',
                                  answer: 'It is normal to get some redness underneath the middle strap; ' +
                                      'this should fade when the boots are off. If you feel the redness is ' +
                                      'getting worse or becoming sore, please let your Physiotherapist know and ' +
                                      'they will be able to help with this.'
                              },
                              {
                                  question: 'There are other marks on the foot',
                                  answer: 'Occasionally you may get marks on other areas of the feet, ' +
                                      'maybe from a crease or seam of a sock. They rarely cause a problem; ' +
                                      'however always contact your Physiotherapist if you have concerns.'
                              }
                          ]}
                />
            </div>
        );
    }
}

export default FAQSplash;

if (document.getElementById('faq')) {
    ReactDOM.render(<FAQSplash/>, document.getElementById('faq'));
}
