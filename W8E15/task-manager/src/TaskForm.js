import { useState, useEffect } from "react";

function TaskForm({ addTask, setShowForm, editTask }) {
    const [formData, setFormData] = useState({
        name: '',
        description: ''
    });

    useEffect(() => {
        if (editTask) {
            setFormData({
                name: editTask.name,
                description: editTask.description
            });
        }
    }, [editTask]);

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        addTask(formData);
        setFormData({ name: '', description: '' });
    };

    return (
        <form onSubmit={handleSubmit} className="border p-4 bg-light">
            <div className="form-group">
                <label htmlFor="name">Task Name:</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    className="form-control"
                    value={formData.name}
                    onChange={handleChange}
                    required
                />
            </div>
            <div className="form-group">
                <label htmlFor="description">Task Description:</label>
                <textarea
                    id="description"
                    name="description"
                    className="form-control"
                    value={formData.description}
                    onChange={handleChange}
                    required
                />
            </div>
            <button type="submit" className="btn btn-success">
                {editTask ? "Update Task" : "Add Task"}
            </button>
            <button
                type="button"
                className="btn btn-secondary ml-2"
                onClick={() => setShowForm(false)}
            >
                Cancel
            </button>
        </form>
    );
}

export default TaskForm;
