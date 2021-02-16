import React from "react";

//TODO -- it doesnt select the right number, always have to click the button twice.
class OutcomeQuestion extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            1: false,
            2: false,
            3: false,
            4: false,
            selectedAnswer: 0,
        }
    }

    selectAnswer(answerId) {
        // set everything to false as we can only have 1 answer selected
        this.setState({
            1: false,
            2: false,
            3: false,
            4: false,
            [answerId]: !this.state.[answerId],
            selectedAnswer: answerId,
        })
        this.props.handleQuestionSubmit(this.props.questionNumber, this.state.selectedAnswer)
    }

    render() {
        const oneColour = this.state.[1] ? 'green-500' : 'white';
        const twoColour = this.state.[2] ? 'green-500' : 'white';
        const threeColour = this.state.[3] ? 'green-500' : 'white';
        const fourColour = this.state.[4] ? 'green-500' : 'white';

        return (
            <div className={"w-11/12 lg:w-1/2 m-2 mt-14 m-auto rounded p-4 shadow-md text-center bg-blue-100"}>
                <h1>{this.props.question}</h1>
                <div className={"grid grid-cols-2"}>
                    <p className={"shadow-md rounded p-2 m-2 w-24 justify-self-center cursor-pointer transition duration-500 bg-" + oneColour}
                       onClick={() => this.selectAnswer(1)}>{this.props.answers.one}</p>
                    <p className={"shadow-md rounded p-2 m-2 w-24 justify-self-center cursor-pointer transition duration-500 bg-" + twoColour}
                       onClick={() => this.selectAnswer(2)}>{this.props.answers.two}</p>
                    <p className={"shadow-md rounded p-2 m-2 w-24 justify-self-center cursor-pointer transition duration-500 bg-" + threeColour}
                       onClick={() => this.selectAnswer(3)}>{this.props.answers.three}</p>
                    <p className={"shadow-md rounded p-2 m-2 w-24 justify-self-center cursor-pointer transition duration-500 bg-" + fourColour}
                       onClick={() => this.selectAnswer(4)}>{this.props.answers.four}</p>
                </div>
            </div>
        )
    }
}

export default OutcomeQuestion;
