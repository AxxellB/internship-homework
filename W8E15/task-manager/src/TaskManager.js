import {createContext, useState} from "react";
import TaskList from "./TaskList";
import TaskForm from "./TaskForm";

export const TasksContext = createContext(null);
function TaskManager() {
    const [tasks, setTasks] = useState([]);
    const [showForm, setShowForm] = useState(false);
    const [editTask, setEditTask] = useState(null);

    const saveTask = (task) => {
        if (editTask) {
            const updatedTasks = tasks.map(t =>
                t.name === editTask.name ? task : t
            );
            setTasks(updatedTasks);
        } else {
            setTasks([...tasks, task]);
        }
        setEditTask(null);
        setShowForm(false);
    };

    const deleteTask = (taskName) => {
        const updatedTasks = tasks.filter(task => task.name !== taskName);
        setTasks(updatedTasks);
    };

    const handleEdit = (task) => {
        setEditTask(task);
        setShowForm(true);
    };

    return (
        <div className="container mt-4">
            {showForm ? (
                <TasksContext.Provider value={{saveTask: saveTask, setShowForm: setShowForm, editTask: editTask}}>
                    <TaskForm/>
                </TasksContext.Provider>
            ) : (
                <>
                    <button
                        className="btn btn-primary mb-3"
                        onClick={() => setShowForm(true)}
                    >
                        Add Task
                    </button>
                    {tasks.length === 0 && <p>No tasks available</p>}
                    <div className="list-group">
                        {tasks.map((task, index) => (
                            <div key={index} className="list-group-item d-flex justify-content-between align-items-center">
                                <TaskList name={task.name} description={task.description} />
                                <div>
                                    <button
                                        className="btn btn-warning btn-sm mr-2"
                                        onClick={() => handleEdit(task)}
                                    >
                                        Edit
                                    </button>
                                    <button
                                        className="btn btn-danger btn-sm"
                                        onClick={() => deleteTask(task.name)}
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        ))}
                    </div>
                </>
            )}
        </div>
    );
}

export default TaskManager;
