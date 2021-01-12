import { data } from 'autoprefixer';
import React from 'react';


function DailyAdheranceView(props) {
    return (
        <div>
            {Object.entries(props.data).map(([key, value]) => {
                var circleColour = value ? 'green' : 'red'
                var classStyle = 'daily-adherance border-' + circleColour + '-400 hover:bg-' + circleColour + '-400'
                return (
                    <div key={key} className={classStyle}>
                        {key[0]}
                    </div>
                )
            })}
        </div>
    )
}

export default DailyAdheranceView
