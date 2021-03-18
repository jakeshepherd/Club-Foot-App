import React from "react";

class OutcomeQuestion extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            1: false,
            2: false,
        }
    }

    selectAnswer(answerId) {
        // set everything to false as we can only have 1 answer selected
        this.setState({
            1: false,
            2: false,
            [answerId]: !this.state.[answerId],
        })
        this.props.handleQuestionSubmit(this.props.questionNumber, answerId)
    }

    render() {
        const oneColour = this.state.[1] ? 'green-500' : 'white';
        const twoColour = this.state.[2] ? 'green-500' : 'white';

        return (
            <div className={"w-11/12 lg:w-1/2 m-2 mt-14 m-auto rounded p-4 shadow-md text-center bg-blue-100"}>
                <h1>{this.props.question}</h1>
                <div className={"grid md:grid-cols-2 grid-cols-1 mt-4"}>
                    <p className={"shadow-md rounded p-2 m-2 w-24 justify-self-center cursor-pointer transition duration-500 bg-" + oneColour}
                       onClick={() => this.selectAnswer(1)}>{this.props.answers.one}</p>
                    <p className={"shadow-md rounded p-2 m-2 w-24 justify-self-center cursor-pointer transition duration-500 bg-" + twoColour}
                       onClick={() => this.selectAnswer(2)}>{this.props.answers.two}</p>
                </div>
            </div>
        )
    }
}

export default OutcomeQuestion;
