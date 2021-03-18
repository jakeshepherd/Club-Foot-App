import React from 'react';

import ReactTooltip from 'react-tooltip';
import information from "../../images/icons8-information.svg";

function DailyAdherenceView(props) {
    return (
        <div className={"w-max m-auto"}>
            {Object.entries(props.data).map(([key, value]) => {
                var circleColour = value ? 'green' : 'red'
                var classStyle = 'daily-adherance border-' + circleColour + '-400 hover:bg-' + circleColour + '-400'
                return (
                    <div data-tip={key} key={key} className={classStyle}>
                        {key[0]}
                        <ReactTooltip />
                    </div>
                )
            })}
            <img data-tip={"Green circles indicate days the time goal was completed, red show when you didn\'t and grey shows no data available."}
                 className={"ml-4 w-8 inline-block rounded-full hover:shadow-md"} src={information}
                 alt={"information"}
            />
        </div>
    )
}

export default DailyAdherenceView
