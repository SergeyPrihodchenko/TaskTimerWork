import { Button, TextField } from '@mui/material';
import { useState } from 'react';
import './App.css';

const App = () => {

  const [value, setValue] = useState('');


  const handleChange = (e) => {
        setValue(e.target.value);
    }

  const getTasks = async () => {
    const response = await fetch('./backEnd/index.php', {
      method: 'POST'
    });
    const result = await response.json();

    return result;
  }

  const [tasks, setTasks] = useState(getTasks());

  const addTask = async () => {

        const data = {
          name: value
        }
        const response = await fetch('./backEnd/index.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        });
        setValue('');
        const result = await response.json();
        console.log(result);
        setTasks(getTasks());
    }

    const deleteTask = async (e) => {
      await fetch('./backEnd/index.php', {
        method: "POST",
        body: JSON.stringify({id: e.target.id})
      })
      setTasks(getTasks());
    }

  
  return (
    <div className="App">
      <div className='inputBlock'>
        <TextField style={{marginRight: '5px'}} id="outlined-basic" label="Task   name" variant="outlined" value={value} onChange={handleChange}/>
        <Button variant="contained" onClick={addTask}>Add task</Button>
      </div>
      <div className='blockTasks'>
          {tasks.map((el, key) => {return <div className='blockText' key={key}><span className='taskText' key={el.id}>{`${key + 1}: ${el}`}</span><span onClick={deleteTask} key={el.id} id={el.id} className='deletTask'>X</span></div>}) || null}
      </div>
    </div>
  );
}

export default App;
