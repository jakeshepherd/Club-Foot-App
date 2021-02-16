import React from 'react';
import ReactDOM from 'react-dom';
import OutcomeQuestion from "./OutcomeQuestion";

import {toast, ToastContainer} from 'react-toastify';

class QuestionnaireSplash extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            questionnaire_data: {}
        }
        this.handleQuestionSubmit = this.handleQuestionSubmit.bind(this);
        this.questionnaireSubmit = this.questionnaireSubmit.bind(this);
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        console.log(this.state.questionnaire_data)
    }

    handleQuestionSubmit(question, answer) {
        this.setState({
            questionnaire_data: {...this.state.questionnaire_data, [question]: answer}
        })
    }

    questionnaireSubmit() {
        axios.post(`/roye-outcome-questionnaire`, this.state)
            .then(() =>
                toast.success("✅ Questionnaire Submitted")
            ).catch(error => toast.error(error.response.data))
    }

    render() {
        const questionnaireData = {
            q1: {
                question: "How satisfied are you with the status of your child's foot?",
                answers: {
                    one: 'Very Satisfied',
                    two: 'Somewhat Satisfied',
                    three: 'Somewhat Dissatisfied',
                    four: 'Very Dissatisfied'
                }
            },
            q2: {
                question: "How satisfied are you with the appearance of your child's foot?",
                answers: {
                    one: 'Very Satisfied',
                    two: 'Somewhat Satisfied',
                    three: 'Somewhat Dissatisfied',
                    four: 'Very Dissatisfied'
                }
            },
            q3: {
                question: "How often is your child teased because of his or her clubfoot?",
                answers: {
                    one: 'Never',
                    two: 'Sometimes',
                    three: 'Usually',
                    four: 'Always'
                }
            },
            q4: {
                question: "How often does your child have problems finding shoes that fit?",
                answers: {
                    one: 'Never',
                    two: 'Sometimes',
                    three: 'Usually',
                    four: 'Always'
                }
            },
            q5: {
                question: "How often does your child have problems finding shoes that he or she likes?",
                answers: {
                    one: 'Never',
                    two: 'Sometimes',
                    three: 'Usually',
                    four: 'Always'
                }
            },
            q6: {
                question: "Does your child ever complain of pain in his or her [affected] foot?",
                answers: {
                    one: 'Yes',
                    two: 'No',
                }
            },
            q7: {
                question: "How limited is your child in his or her ability to walk?",
                answers: {
                    one: 'Not at all limited',
                    two: 'Somewhat limited',
                    three: 'Moderately limited',
                    four: 'Very limited'
                }
            },
            q8: {
                question: "How limited is your child in his or her ability to run?",
                answers: {
                    one: 'Not at all limited',
                    two: 'Somewhat limited',
                    three: 'Moderately limited',
                    four: 'Very limited'
                }
            },
            q9: {
                question: "How often does your child complain of pain during heavy exercise?",
                answers: {
                    one: 'Never',
                    two: 'Sometimes',
                    three: 'Usually',
                    four: 'Always'
                }
            },
            q10: {
                question: "How often does your child complain of pain during moderate exercise?",
                answers: {
                    one: 'Never',
                    two: 'Sometimes',
                    three: 'Usually',
                    four: 'Always'
                }
            },
        }

        return (
            <React.Fragment>
                <div className="p-5 m-auto w-10/12 text-center mb-28">
                    <h1>Outcome Questionnaire</h1>
                    {Object.values(questionnaireData).map(function (key, value) {
                        return <OutcomeQuestion
                            key={value}
                            questionNumber={value}
                            question={key.question}
                            answers={key.answers}
                            handleQuestionSubmit={this.handleQuestionSubmit}
                        />
                    }.bind(this))}
                    <ToastContainer pauseOnFocusLoss draggable/>
                </div>
                <div className={"flex justify-center"}>
                    <button className={"button rounded-full p-2 w-24 bg-blue-400 hover:bg-blue-500 fixed bottom-16"}
                            onClick={this.questionnaireSubmit}>Submit
                    </button>
                </div>
            </React.Fragment>
        );
    }

}

export default QuestionnaireSplash;

if (document.getElementById('outcome-questionnaire')) {
    ReactDOM.render(<QuestionnaireSplash/>, document.getElementById('outcome-questionnaire'));
}