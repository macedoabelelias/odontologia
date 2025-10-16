import React, { useState } from 'react';
import './odontogram.css';

const Odontogram = () => {
    const initialTeethState = Array(32).fill('toBePerformed'); // 32 teeth
    const [teethStatus, setTeethStatus] = useState(initialTeethState);

    const handleToothClick = (index) => {
        const newStatus = teethStatus[index] === 'toBePerformed' ? 'performing' : 
                          teethStatus[index] === 'performing' ? 'performed' : 
                          'toBePerformed';
        const updatedTeethStatus = [...teethStatus];
        updatedTeethStatus[index] = newStatus;
        setTeethStatus(updatedTeethStatus);
    };

    return (
        <div className="odontogram">
            {teethStatus.map((status, index) => (
                <div 
                    key={index} 
                    className={`tooth ${status}`} 
                    onClick={() => handleToothClick(index)}
                >
                    {index + 1} {/* Tooth number */}
                </div>
            ))}
        </div>
    );
};

export default Odontogram;