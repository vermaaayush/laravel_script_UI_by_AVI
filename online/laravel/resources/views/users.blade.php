<table>
    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap"ead class="bg-surface-container-low text-on-surface-variant font-semibold">
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap">Name</th>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap">Email</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $user->name }}</td>
            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $user->email }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
