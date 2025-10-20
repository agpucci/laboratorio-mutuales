<?php foreach ($logs as $l): ?>
  <tr>
    <td><?= htmlspecialchars($l['created_at']) ?></td>
    <td><?= htmlspecialchars($l['username'] ?? ('#'.$l['user_id'])) ?></td>
    <td><?= htmlspecialchars($l['action']) ?></td>
    <td><small><?= htmlspecialchars(mb_strimwidth((string)($l['new_value'] ?? $l['old_value'] ?? ''),0,120,'…')) ?></small></td>
  </tr>
<?php endforeach; ?>
</tbody></table>
