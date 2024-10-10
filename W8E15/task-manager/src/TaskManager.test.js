import React from 'react';
import { render, screen, fireEvent } from '@testing-library/react';
import TaskManager from './TaskManager';

test('renders TaskManager and adds a task', () => {
    render(<TaskManager />);

    const addTaskButton = screen.getByText(/Add Task/i);
    expect(addTaskButton).toBeInTheDocument();

    fireEvent.click(addTaskButton);

    const nameInput = screen.getByLabelText(/Task Name/i);
    const descriptionInput = screen.getByLabelText(/Task Description/i);
    fireEvent.change(nameInput, { target: { value: 'New Task' } });
    fireEvent.change(descriptionInput, { target: { value: 'This is a new task' } });

    const saveButton = screen.getByText(/Add Task/i);
    fireEvent.click(saveButton);

    const taskElement = screen.getByRole('heading', {name: /New Task/i});
    expect(taskElement).toBeInTheDocument();
});

test('edits a task successfully', () => {
    render(<TaskManager />);

    const addTaskButton = screen.getByRole('button', { name: /Add Task/i });
    fireEvent.click(addTaskButton);

    const nameOriginalInput = screen.getByLabelText(/Task Name/i);
    const descriptionOriginalInput = screen.getByLabelText(/Task Description/i);
    fireEvent.change(nameOriginalInput, { target: { value: 'Original Task' } });
    fireEvent.change(descriptionOriginalInput, { target: { value: 'This is an original task' } });

    const saveOriginalButton = screen.getByText(/Add Task/i);
    fireEvent.click(saveOriginalButton);
    const taskOriginalElement = screen.getByRole('heading', {name: /Original Task/i});
    expect(taskOriginalElement).toBeInTheDocument();

    const editTaskButton = screen.getByText(/Edit/i);
    expect(editTaskButton).toBeInTheDocument();

    fireEvent.click(editTaskButton);

    const nameInput = screen.getByLabelText(/Task Name/i);
    const descriptionInput = screen.getByLabelText(/Task Description/i);
    fireEvent.change(nameInput, { target: { value: 'Edited Task' } });
    fireEvent.change(descriptionInput, { target: { value: 'This is an edited task' } });

    const saveButton = screen.getByText(/Update Task/i);
    fireEvent.click(saveButton);

    const taskElement = screen.getByRole('heading', {name: /Edited Task/i});
    expect(taskElement).toBeInTheDocument();
});

test('deletes a task successfully', () => {
    render(<TaskManager />);

    const addTaskButton = screen.getByRole('button', { name: /Add Task/i });
    fireEvent.click(addTaskButton);

    const nameOriginalInput = screen.getByLabelText(/Task Name/i);
    const descriptionOriginalInput = screen.getByLabelText(/Task Description/i);
    fireEvent.change(nameOriginalInput, { target: { value: 'Original Task' } });
    fireEvent.change(descriptionOriginalInput, { target: { value: 'This is an original task' } });

    const saveOriginalButton = screen.getByText(/Add Task/i);
    fireEvent.click(saveOriginalButton);
    const taskOriginalElement = screen.getByRole('heading', {name: /Original Task/i});
    expect(taskOriginalElement).toBeInTheDocument();

    const deleteTaskButton = screen.getByText(/Delete/i);
    expect(deleteTaskButton).toBeInTheDocument();

    fireEvent.click(deleteTaskButton);

    const deletedTaskElement = screen.queryByRole('heading', { name: /Original Task/i });
    expect(deletedTaskElement).not.toBeInTheDocument();
});
