import { Button, TextField } from '@mui/material';
import { useCallback, useEffect, useState } from 'react';
import './App.css';

const App = () => {

  const [tasks, setTasks] = useState([]);
  const [value, setValue] = useState('');
  const [dummy, setDummy] = useState({});
  const handleChange = (e) => {
      setValue(e.target.value);
  }

  const saveTask = () => {
     fetch('./backEnd/index.php', {
      method: 'POST',
      headers: {
        'ACTION': 'SAVE'
      },
      body: JSON.stringify({name: value})
    })
    .then(response => {
      return response.json()
    })
    .then(res => {
      console.log(res);
      setValue('');
      setDummy({});
    })
  }

  const deleteTask = (e) => {
     fetch('./backEnd/index.php', {
      method: 'POST',
      headers: {
        'ACTION': 'DELETE'
      },
      body: JSON.stringify({id_task: e.target.id})
    })
    .then(response => {
      return response.json();
    })
    .then(res => {
      console.log(res);
      setDummy({});
    })
  }

  useEffect(() => {
    fetch('./backEnd/index.php', {
      method: 'POST',
      headers: {
        'ACTION': 'GET_TASK'
      },
    })
    .then(response => {
      return response.json();
    })
    .then(res => {
      console.log(res);
      setTasks(res.data.tasks);
    });
  }, [dummy]);
  
  const renderTask = useCallback((el, key) => {
      return <div className='blockText' key={key}><span className='taskText' key={key}>{key + 1} : {el.name}</span><span className='date_started' key={key}>{el.date_started}</span><span onClick={deleteTask} className='deleteTask' id={el.id} key={key}>X</span></div>
  },[]);

  return (
    <div className="App">
      <div className='inputBlock'>
        <TextField style={{marginRight: '5px'}} id="outlined-basic" label="Task   name" variant="outlined" onChange={handleChange} value={value}/>
        <Button variant="contained" onClick={saveTask}>Add task</Button>
      </div>
      <div className='blockTasks'>
        <ul>
          {tasks.map(renderTask)}
        </ul>
      </div>
    </div>
  );
}

export default App;
