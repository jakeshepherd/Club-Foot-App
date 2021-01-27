import React from 'react';

import ReactTooltip from 'react-tooltip';

function DailyAdherenceView(props) {
    return (
        <div>
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
        </div>
    )
}

export default DailyAdherenceView
